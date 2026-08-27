<?php

namespace App\Http\Controllers;

use App\Models\PetugasAbsensi;
use App\Models\AttendanceRecord;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AbsensiController extends Controller
{
    /**
     * Tampilkan Halaman Absensi Utama (pages.absensi)
     */
    public function index()
    {
        $roster = [];
        $folderPath = storage_path('app/Data Kelas X Tahun 2026');

        // Baca Data Roster dari Excel
        if (file_exists($folderPath)) {
            $files = glob($folderPath . '/*.xlsx');

            foreach ($files as $filePath) {
                try {
                    $spreadsheet = IOFactory::load($filePath);

                    foreach ($spreadsheet->getAllSheets() as $sheet) {
                        $sheetTitle = trim($sheet->getTitle());
                        $cellA1 = trim((string)$sheet->getCell('A1')->getValue());

                        $rawKelasText = $cellA1 . ' ' . $sheetTitle;
                        $namaKelas = '';

                        if (preg_match('/X\s+(AKL|MPLB|PM|PPLG|TO)\s*\d+/i', $rawKelasText, $matches)) {
                            $namaKelas = strtoupper(preg_replace('/\s+/', ' ', $matches[0]));
                        } else {
                            $namaKelas = !empty($cellA1) ? $cellA1 : $sheetTitle;
                        }

                        $rows = $sheet->toArray();
                        if (empty($rows)) continue;

                        $colNama  = 4;
                        $colJK    = 6;
                        $startRow = 3;

                        foreach (array_slice($rows, 0, 6) as $rIndex => $rData) {
                            foreach ($rData as $cIndex => $cValue) {
                                $val = strtolower(trim((string)$cValue));
                                if (str_contains($val, 'nama lengkap') || str_contains($val, 'nama siswa') || $val === 'nama') {
                                    $colNama  = $cIndex;
                                    $startRow = $rIndex + 1;
                                }
                                if (str_contains($val, 'jenis kelamin') || $val === 'jk' || str_contains($val, 'kelamin')) {
                                    $colJK = $cIndex;
                                }
                            }
                        }

                        for ($i = $startRow; $i < count($rows); $i++) {
                            $row = $rows[$i];
                            $nama  = trim((string)($row[$colNama] ?? ''));
                            $jkRaw = strtolower(trim((string)($row[$colJK] ?? '')));

                            if (empty($nama) || str_contains(strtolower($nama), 'nama lengkap') || str_contains(strtolower($nama), 'nama siswa')) {
                                continue;
                            }

                            $ambalan = '';
                            if (str_contains($jkRaw, 'laki') || $jkRaw === 'l' || str_contains($jkRaw, 'putra')) {
                                $ambalan = 'Putra';
                            } elseif (str_contains($jkRaw, 'perempuan') || $jkRaw === 'p' || str_contains($jkRaw, 'putri')) {
                                $ambalan = 'Putri';
                            }

                            $roster[] = [
                                'id'      => count($roster) + 1,
                                'name'    => mb_strtoupper($nama, 'UTF-8'),
                                'kelas'   => $namaKelas,
                                'ambalan' => $ambalan,
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    // Abaikan file bermasalah
                }
            }
        }

        // Kembalikan View ASLI Anda
        return view('pages.absensi', compact('roster'));
    }

    /**
     * Process Verifikasi (Dipanggil oleh Modal/Form Verifikasi di pages.absensi)
     */
    public function verify(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'kelas' => 'required|string',
            'nta'   => 'required|string',
        ]);

        $cleanNta  = trim($request->nta);
        $cleanName = strtolower(trim($request->name));

        // CARI EXACT MATCH DI DATABASE PETUGAS ADMIN
        $petugas = PetugasAbsensi::where('nta', $cleanNta)
            ->whereRaw('LOWER(TRIM(nama)) = ?', [$cleanName])
            ->first();

        if (! $petugas) {
            return redirect()->route('absensi.index')
                ->with('absensi_verify_error', 'Akses Ditolak! Nama atau NTA tidak terdaftar di sistem admin.');
        }

        if (! $petugas->is_approved || ! $petugas->is_active) {
            return redirect()->route('absensi.index')
                ->with('absensi_verify_error', 'Akses Ditolak! Akun petugas tidak aktif atau belum disetujui.');
        }

        // Simpan ke Session
        session([
            'absensi_verified' => [
                'name'  => $petugas->nama,
                'kelas' => trim($request->kelas),
                'nta'   => $petugas->nta,
            ],
            'absensi_petugas_id' => $petugas->id,
        ]);

        $petugas->update(['terakhir_melakukan' => now()]);

        return redirect()->route('absensi.index');
    }

    /**
     * Submit Absensi (Integritas Data & Proteksi Real-Time)
     */
    public function submit(Request $request)
    {
        $verified = session('absensi_verified');

        if (! $verified || empty($verified['nta'])) {
            return redirect()->route('absensi.index')
                ->with('absensi_verify_error', 'Sesi Anda telah berakhir. Silakan verifikasi ulang.');
        }

        // Validasi Status Aktif Real-Time dari DB
        $petugas = PetugasAbsensi::where('nta', $verified['nta'])->first();
        if (! $petugas || ! $petugas->is_active || ! $petugas->is_approved) {
            session()->forget(['absensi_verified', 'absensi_petugas_id']);
            return redirect()->route('absensi.index')
                ->with('absensi_verify_error', 'Akses Ditolak! Status keaktifan Anda telah dinonaktifkan Admin.');
        }

        $statuses         = $request->input('status', []);
        $participantNames = $request->input('participant_name', []);
        $participantKelas = $request->input('participant_kelas');
        $participantAmbalan = $request->input('participant_ambalan');
        $iurans           = $request->input('iuran', []);
        $bulan            = $request->input('bulan');
        $tanggal          = $request->input('tanggal');
        $tahun            = $request->input('tahun');

        if (! $bulan || ! $tanggal || ! $tahun || empty($statuses) || ! $participantKelas) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Data absensi tidak lengkap.');
        }

        $bulanMap = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12'
        ];
        $blnNum = $bulanMap[$bulan] ?? date('m');
        $tglNum = str_pad($tanggal, 2, '0', STR_PAD_LEFT);

        $recordDate = "{$tahun}-{$blnNum}-{$tglNum}";
        $monthKey   = "{$tahun}-{$blnNum}";
        $weekNumber = date('W', strtotime($recordDate));
        $weekLabel  = "Minggu " . $weekNumber . " " . $bulan . " " . $tahun;

        $rows = [];
        $now  = now();

        foreach ($statuses as $id => $status) {
            if (! $status) continue;

            $rows[] = [
                'participant_id'      => $id,
                'participant_name'    => mb_strtoupper($participantNames[$id] ?? 'UNKNOWN', 'UTF-8'),
                'participant_kelas'   => $participantKelas,
                'participant_ambalan' => $participantAmbalan ?? '',
                'ambalan'             => $participantAmbalan ?? '',
                'tanggal'             => $tanggal,
                'bulan'               => $bulan,
                'tahun'               => $tahun,
                'week_label'          => $weekLabel,
                'month_key'           => $monthKey,
                'year_key'            => (string) $tahun,
                'record_date'         => $recordDate,
                'status'              => $status,
                'iuran'               => $iurans[$id] ?? 'Tidak',

                // Menyimpan NTA Petugas untuk Penghitungan Rekam di Admin
                'petugas_name'  => $verified['name'],
                'petugas_kelas' => $verified['kelas'],
                'petugas_nta'   => $verified['nta'],

                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($rows)) {
            // 1. Simpan detail absensi siswa menggunakan updateOrCreate untuk mencegah duplikasi
            foreach ($rows as $row) {
                // Pastikan field yang tidak di-fillable tidak dikirim ke updateOrCreate
                $data = $row;
                unset($data['created_at'], $data['updated_at']);

                AttendanceRecord::updateOrCreate(
                    [
                        'record_date'         => $row['record_date'],
                        'participant_name'    => $row['participant_name'],
                        'participant_kelas'   => $row['participant_kelas'],
                        'participant_ambalan' => $row['participant_ambalan'] ?? null,
                    ],
                    $data
                );
            }

            // 2. Update waktu terakhir & Tambah 1 ke jumlah_rekam petugas
            $petugas->increment('jumlah_rekam');
            $petugas->update(['terakhir_melakukan' => now()]);
        }

        return redirect()->route('absensi.index')->with('absensi_success', 'Submit absensi berhasil disimpan!');
    }
}