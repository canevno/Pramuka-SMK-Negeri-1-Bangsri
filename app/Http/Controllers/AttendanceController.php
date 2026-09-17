<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index()
    {
        $ambalan = strtoupper(trim((string) session('absensi_verified.ambalan', 'PA')));
        $sangga = trim((string) session('absensi_verified.sangga', 'Perintis'));

        $roster = $this->attendanceRoster($ambalan, $sangga);
        $sanggaList = $this->sanggaList($ambalan);

        return view('pages.absensi', compact('roster', 'sanggaList'));
    }

    public function submit(Request $request)
    {
        if (! $request->session()->has('absensi_verified')) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Silakan verifikasi terlebih dahulu.');
        }

        $statuses = $request->input('status', []);
        $participantNames = $request->input('participant_name', []);
        $participantKelas = $request->input('participant_kelas', []);
        $participantAmbalan = $request->input('participant_ambalan', []);
        $participantSangga = $request->input('participant_sangga', $request->input('participant_sub_sangga', []));
        $iurans = $request->input('iuran', []);
        $iuranAmounts = $request->input('iuran_amount', []);
        $bulan = trim((string) $request->input('bulan', ''));
        $tanggal = trim((string) $request->input('tanggal', ''));
        $tahun = trim((string) $request->input('tahun', ''));

        $participantKelasValue = is_array($participantKelas) ? trim((string) reset($participantKelas)) : trim((string) $participantKelas);
        $participantAmbalanValue = is_array($participantAmbalan) ? trim((string) reset($participantAmbalan)) : trim((string) $participantAmbalan);
        $participantSanggaValue = is_array($participantSangga) ? trim((string) reset($participantSangga)) : trim((string) $participantSangga);

        if ($bulan === '' || $tanggal === '' || $tahun === '' || empty($statuses) || $participantKelasValue === '' || $participantAmbalanValue === '' || $participantSanggaValue === '' || empty($iurans)) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Data absensi tidak lengkap.');
        }

        $rows = [];
        $weekLabel = $this->generateWeekLabel($bulan, $tanggal, $tahun);
        $monthKey = $this->generateMonthKey($bulan, $tahun);
        $yearKey = (string) $tahun;
        $recordDate = $this->generateRecordDate($bulan, $tanggal, $tahun);

        foreach ($statuses as $id => $status) {
            if (! filled($status)) {
                continue;
            }

            $iuranValue = trim((string) ($iurans[$id] ?? 'Tidak'));
            $iuranAmountValue = (int) ($iuranAmounts[$id] ?? 0);
            if ($iuranValue !== 'Tidak' && $iuranAmountValue === 0) {
                $iuranAmountValue = 2000;
            }

            $rows[] = [
                'bulan' => $bulan,
                'tanggal' => $tanggal,
                'tahun' => $tahun,
                'participant_id' => (string) $id,
                'participant_name' => trim((string) ($participantNames[$id] ?? 'Unknown')),
                'participant_kelas' => $participantKelasValue,
                'participant_ambalan' => $participantAmbalanValue,
                'participant_sangga' => trim((string) (($participantSangga[$id] ?? $participantSanggaValue) ?: session('absensi_verified.sangga', 'Perintis'))),
                'status' => (string) $status,
                'iuran' => $iuranValue,
                'iuran_amount' => $iuranAmountValue,
                'petugas_name' => $request->session()->get('absensi_verified.name'),
                'petugas_kelas' => $request->session()->get('absensi_verified.kelas'),
                'petugas_nta' => $request->session()->get('absensi_verified.nta'),
                'week_label' => $weekLabel,
                'month_key' => $monthKey,
                'year_key' => $yearKey,
                'record_date' => $recordDate,
            ];
        }

        if (empty($rows)) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Tidak ada data peserta yang dikirim.');
        }

        try {
            foreach ($rows as $row) {
                AttendanceRecord::create($row);
            }
        } catch (\Throwable $e) {
            Log::error('Absensi submission failed', [
                'error' => $e->getMessage(),
                'rows' => $rows,
            ]);

            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Gagal menyimpan absensi ke database.');
        }

        return redirect()->route('absensi.index')->with('absensi_success', 'Submit berhasil');
    }

    private function attendanceRoster(?string $ambalan = null, ?string $sangga = null): array
    {
        $ambalan = $ambalan ? strtoupper(trim($ambalan)) : null;
        $sangga = $sangga ? trim($sangga) : null;

        $query = Student::query();

        if ($ambalan) {
            $query->where('ambalan', $ambalan);
        }

        if ($sangga) {
            $query->whereRaw('UPPER(sangga) = ?', [strtoupper($sangga)]);
        }

        $students = $query
            ->orderBy('sangga')
            ->orderBy('sub_sangga')
            ->orderBy('nama')
            ->get();

        if ($students->isNotEmpty()) {
            return $students->map(function (Student $student, int $index) {
                return [
                    'id' => $student->id,
                    'nama' => $student->nama,
                    'name' => $student->nama,
                    'kelas' => $student->kelas_asal,
                    'kelas_asal' => $student->kelas_asal,
                    'kelas_asal_real' => $student->kelas_asal,
                    'ambalan' => $student->ambalan,
                    'sangga' => $student->sangga,
                    'sub_sangga' => $student->sub_sangga,
                ];
            })->all();
        }

        $fallbackAmbalan = $ambalan ?: 'PA';
        $fallbackFile = $fallbackAmbalan === 'PI'
            ? storage_path('app/Data Kelas X Tahun 2026/ABSENSI PI.csv')
            : storage_path('app/Data Kelas X Tahun 2026/ABSENSI PA.csv');

        if (! file_exists($fallbackFile)) {
            return [];
        }

        $rows = [];
        $currentSangga = null;
        $currentSubSangga = null;
        $handle = fopen($fallbackFile, 'r');

        while (($line = fgets($handle)) !== false) {
            $delimiter = str_contains($line, ';') ? ';' : ',';
            $data = str_getcsv($line, $delimiter);
            $cellA = isset($data[0]) ? trim($data[0]) : '';
            $cellB = isset($data[1]) ? trim($data[1]) : '';
            $cellC = isset($data[2]) ? trim($data[2]) : '';

            if (preg_match('/^(PERINTIS|PENEGAS|PENCOBA|PENDOBRAK|PELAKSANA)\s+(\d+)\s*(PA|PI)?/i', $cellA, $matches)) {
                $currentSangga = strtoupper($matches[1]);
                $currentSubSangga = (string) $matches[2];
                continue;
            }

            if (is_numeric($cellA) && $cellB !== '' && strtolower($cellB) !== 'nama lengkap') {
                if ($sangga && strtoupper($currentSangga ?? '') !== strtoupper($sangga)) {
                    continue;
                }

                $rows[] = [
                    'id' => count($rows) + 1,
                    'nama' => $cellB,
                    'name' => $cellB,
                    'kelas' => $cellC,
                    'kelas_asal' => $cellC,
                    'ambalan' => $fallbackAmbalan,
                    'sangga' => $currentSangga,
                    'sub_sangga' => $currentSubSangga,
                ];
            }
        }

        fclose($handle);

        return $rows;
    }

    private function sanggaList(string $ambalan): array
    {
        $ambalan = strtoupper(trim($ambalan ?: 'PA'));

        $sangga = Student::query()
            ->where('ambalan', $ambalan)
            ->select('sangga')
            ->distinct()
            ->pluck('sangga')
            ->filter()
            ->map(fn ($value) => ucfirst(strtolower((string) $value)))
            ->unique()
            ->values()
            ->all();

        if (! empty($sangga)) {
            return $sangga;
        }

        return ['Perintis', 'Penegas', 'Pencoba', 'Pendobrak', 'Pelaksana'];
    }

    private function generateWeekLabel(string $bulan, string $tanggal, string $tahun): string
    {
        $day = (int) $tanggal;
        $week = (int) ceil($day / 7);

        return sprintf('Minggu %d', $week);
    }

    private function generateMonthKey(string $bulan, string $tahun): string
    {
        return sprintf('%s-%s', $this->monthNumber($bulan), $tahun);
    }

    private function generateRecordDate(string $bulan, string $tanggal, string $tahun): string
    {
        return sprintf('%s-%s-%s', $tahun, $this->monthNumber($bulan), str_pad((string) $tanggal, 2, '0', STR_PAD_LEFT));
    }

    private function monthNumber(string $bulan): string
    {
        $months = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];

        return $months[$bulan] ?? '01';
    }
}
