<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Student;
use App\Models\PetugasAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    // 1. Tampilan FRONT-END (Siswa / Publik)
    public function index(Request $request)
    {
        $sessionVerified = $request->session()->get('absensi_verified');

        $selectedKelas  = $request->query('kelas');
        $selectedSangga = $sessionVerified['target_sangga'] ?? $sessionVerified['sangga'] ?? $request->query('sangga');
        
        // Ambalan DIKUNCI dari session petugas yang terverifikasi
        $rawPetugasAmbalan = $sessionVerified['ambalan'] ?? $request->query('ambalan');
        $normalizedAmbalan = $this->normalizeAmbalan($rawPetugasAmbalan);

        $query = Student::query();

        // 1. FILTER OTOMATIS BERDASARKAN AMBALAN PETUGAS (PA/PI)
        if (! empty($normalizedAmbalan)) {
            $query->whereIn('ambalan', $this->getAmbalanVariants($normalizedAmbalan));
        }

        // 2. FILTER FLEXIBLE SANGGA
        if (filled($selectedSangga)) {
            // Ambil nama dasar sangga (misal: "Pendobrak 1" -> "Pendobrak")
            $sanggaBase = trim(preg_replace('/[0-9]/', '', $selectedSangga));

            $query->where(function ($q) use ($selectedSangga, $sanggaBase) {
                $q->whereRaw('LOWER(sangga) LIKE ?', ['%' . strtolower($selectedSangga) . '%'])
                  ->orWhereRaw('LOWER(sub_sangga) LIKE ?', ['%' . strtolower($selectedSangga) . '%']);

                if (! empty($sanggaBase)) {
                    $q->orWhereRaw('LOWER(sangga) LIKE ?', ['%' . strtolower($sanggaBase) . '%'])
                      ->orWhereRaw('LOWER(sub_sangga) LIKE ?', ['%' . strtolower($sanggaBase) . '%']);
                }
            });
        } elseif (filled($selectedKelas)) {
            $query->where('kelas_asal', $selectedKelas);
        }

        $students = $query->get();

        // FALLBACK LOGIC: Jika filter sangga spesifik 0 data (karena beda ejaan di Excel DB),
        // muat SEMUA siswa yang sesuai Ambalan petugas agar JS front-end bisa memfilter Sub-Sangga.
        if ($students->isEmpty() && ! empty($normalizedAmbalan)) {
            $students = Student::whereIn('ambalan', $this->getAmbalanVariants($normalizedAmbalan))->get();
        } elseif ($students->isEmpty()) {
            $students = Student::all();
        }

        $roster = $students->map(function ($student) {
            return [
                'id'         => $student->id,
                'nama'       => $student->nama,
                'name'       => $student->nama,
                'kelas'      => $student->kelas_asal ?? $student->kelas ?? '',
                'sangga'     => $student->sangga ?? '',
                'sub_sangga' => $student->sub_sangga ?? '',
                'ambalan'    => $student->ambalan ?? '',
            ];
        })->all();

        // AMBIL DATA DINAMIS SANGGA & SUB SANGGA DARI DATABASE
        $sanggaList = Student::whereNotNull('sangga')
            ->where('sangga', '!=', '')
            ->pluck('sangga')
            ->map(fn($item) => trim(preg_replace('/[0-9]/', '', $item)))
            ->unique()
            ->values();

        $subSanggaList = Student::whereNotNull('sub_sangga')
            ->where('sub_sangga', '!=', '')
            ->pluck('sub_sangga')
            ->unique()
            ->values();

        return view('pages.absensi', [
            'roster'          => $roster,
            'students'        => $students,
            'selectedAmbalan' => $normalizedAmbalan,
            'selectedKelas'   => $selectedKelas,
            'selectedSangga'  => $selectedSangga,
            'sanggaList'      => $sanggaList,
            'subSanggaList'   => $subSanggaList,
        ]);
    }

    // 2. Tampilan ADMIN (Dashboard Admin)
    public function adminIndex(Request $request)
    {
        $selectedAmbalan = $request->query('ambalan');
        $selectedKelas   = $request->query('kelas');

        $query = Student::query();

        if (filled($selectedAmbalan)) {
            $normalized = $this->normalizeAmbalan($selectedAmbalan);
            $query->whereIn('ambalan', $this->getAmbalanVariants($normalized));
        }

        if (filled($selectedKelas)) {
            $query->where('kelas_asal', $selectedKelas);
        }

        $students = $query->get();

        $roster = $students->map(function ($student) {
            return [
                'id'         => $student->id,
                'nama'       => $student->nama,
                'name'       => $student->nama,
                'kelas'      => $student->kelas_asal ?? $student->kelas ?? '',
                'sangga'     => $student->sangga ?? '',
                'sub_sangga' => $student->sub_sangga ?? '',
                'ambalan'    => $student->ambalan ?? '',
            ];
        })->all();

        return view('admin.absensi', [
            'roster'          => $roster,
            'students'        => $students,
            'selectedAmbalan' => $selectedAmbalan,
            'selectedKelas'   => $selectedKelas,
        ]);
    }

    // 3. SUBMIT ABSENSI
    public function submit(Request $request)
    {
        if (! $request->session()->has('absensi_verified')) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Silakan verifikasi petugas terlebih dahulu.');
        }

        $verifiedSession = $request->session()->get('absensi_verified');

        $statuses         = $request->input('status', []);
        $participantNames = $request->input('participant_name', []);
        $iurans           = $request->input('iuran', []);
        $bulan            = trim((string) $request->input('bulan', ''));
        $tanggal          = trim((string) $request->input('tanggal', ''));
        $tahun            = trim((string) $request->input('tahun', ''));

        if ($bulan === '' || $tanggal === '' || $tahun === '' || empty($statuses)) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Data tanggal atau status kehadiran tidak lengkap.');
        }

        $studentIds = array_keys($statuses);
        $students   = Student::whereIn('id', $studentIds)->get()->keyBy('id');

        $rows       = [];
        $weekLabel  = $this->generateWeekLabel($bulan, $tanggal, $tahun);
        $monthKey   = $this->generateMonthKey($bulan, $tahun);
        $yearKey    = (string) $tahun;
        $recordDate = $this->generateRecordDate($bulan, $tanggal, $tahun);

        $officerAmbalan = $verifiedSession['ambalan'] ?? '';

        foreach ($statuses as $id => $status) {
            $studentId = (string) $id;

            if (! filled($status) || ! isset($students[$studentId])) {
                continue;
            }

            $studentInfo = $students[$studentId];

            $rows[] = [
                'bulan'               => $bulan,
                'tanggal'             => $tanggal,
                'tahun'               => $tahun,
                'participant_id'      => $studentId,
                'participant_name'    => trim((string) ($participantNames[$studentId] ?? $studentInfo->nama)),
                'participant_kelas'   => $studentInfo->kelas_asal ?? $studentInfo->kelas ?? '',
                'participant_ambalan' => $officerAmbalan ?: ($studentInfo->ambalan ?? ''),
                'status'              => (string) $status,
                'iuran'               => trim((string) ($iurans[$studentId] ?? 'Tidak')),
                'petugas_name'        => $verifiedSession['name'] ?? '',
                'petugas_kelas'       => $verifiedSession['petugas_kelas'] ?? '',
                'petugas_nta'         => $verifiedSession['nta'] ?? '',
                'week_label'          => $weekLabel,
                'month_key'           => $monthKey,
                'year_key'            => $yearKey,
                'record_date'         => $recordDate,
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        if (empty($rows)) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Tidak ada data siswa valid yang dapat disimpan.');
        }

        try {
            DB::transaction(function () use ($rows) {
                AttendanceRecord::insert($rows);
            });
        } catch (\Throwable $e) {
            Log::error('Absensi submission failed', [
                'error' => $e->getMessage(),
                'rows'  => $rows,
            ]);

            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Gagal menyimpan absensi ke database.');
        }

        return redirect()->route('absensi.index')->with('absensi_success', 'Absensi berhasil disimpan!');
    }

    // 4. VERIFIKASI PETUGAS
    public function verifyPetugas(Request $request)
    {
        $sanggaInput = $request->input('sangga') ?? $request->input('target_sangga');

        $request->validate([
            'nta' => 'required|string',
        ]);

        if (! $sanggaInput) {
            return redirect()->back()->with('absensi_verify_error', 'Silakan pilih Sangga terlebih dahulu.');
        }

        $petugas = PetugasAbsensi::where('nta', trim($request->nta))->first();

        if (! $petugas) {
            return redirect()->back()->with('absensi_verify_error', 'NTA Petugas tidak ditemukan.');
        }

        if (isset($petugas->is_approved) && ! $petugas->is_approved) {
            return redirect()->back()->with('absensi_verify_error', 'Akun petugas belum disetujui oleh admin.');
        }

        if (isset($petugas->is_active) && ! $petugas->is_active) {
            return redirect()->back()->with('absensi_verify_error', 'Akun petugas Anda sedang tidak aktif.');
        }

        // Ambil Jenis Kelamin / Ambalan Petugas dan Normalisasi ke 'PA' atau 'PI'
        $rawAmbalan = $petugas->ambalan ?? $petugas->jenis_kelamin ?? $petugas->jk ?? '';
        $normalizedAmbalan = $this->normalizeAmbalan($rawAmbalan);

        $request->session()->put('absensi_verified', [
            'id'            => $petugas->id,
            'name'          => $petugas->nama ?? $petugas->name,
            'petugas_kelas' => $petugas->kelas_petugas ?? $petugas->kelas ?? '',
            'nta'           => $petugas->nta,
            'sangga'        => $sanggaInput,
            'target_sangga' => $sanggaInput,
            'ambalan'       => $normalizedAmbalan, // PA atau PI
        ]);

        return redirect()->back()->with('absensi_success', 'Verifikasi petugas berhasil.');
    }

    public function verify(Request $request)
    {
        return $this->verifyPetugas($request);
    }

    public function logoutPetugas(Request $request)
    {
        $request->session()->forget('absensi_verified');

        return redirect()->route('absensi.index')->with('absensi_success', 'Sesi petugas telah diakhiri.');
    }

    // HELPER FUNCTIONS
    private function normalizeAmbalan(?string $value): string
    {
        if (empty($value)) return '';
        $val = strtoupper(trim($value));

        if (str_contains($val, 'PA') || str_contains($val, 'PUTRA') || str_contains($val, 'LAKI') || $val === 'L') {
            return 'PA';
        }
        if (str_contains($val, 'PI') || str_contains($val, 'PUTRI') || str_contains($val, 'PEREMPUAN') || $val === 'P') {
            return 'PI';
        }
        return $val;
    }

    private function getAmbalanVariants(string $normalizedAmbalan): array
    {
        if ($normalizedAmbalan === 'PA') {
            return ['PA', 'Putra', 'putra', 'L', 'Laki-laki', 'Laki-Laki'];
        }
        if ($normalizedAmbalan === 'PI') {
            return ['PI', 'Putri', 'putri', 'P', 'Perempuan'];
        }
        return [$normalizedAmbalan];
    }

    private function generateWeekLabel(string $bulan, string $tanggal, string $tahun): string
    {
        $date = \DateTime::createFromFormat('!d-m-Y', sprintf('%02d-%s-%s', (int) $tanggal, $this->monthNumber($bulan), $tahun));

        if (! $date) {
            return sprintf('%s %s', $bulan, $tahun);
        }

        $week = (int) $date->format('W');

        return sprintf('Minggu %02d %s %s', $week, $bulan, $tahun);
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
            'Januari'   => '01',
            'Februari'  => '02',
            'Maret'     => '03',
            'April'     => '04',
            'Mei'       => '05',
            'Juni'      => '06',
            'Juli'      => '07',
            'Agustus'   => '08',
            'September' => '09',
            'Oktober'   => '10',
            'November'  => '11',
            'Desember'  => '12',
        ];

        return $months[$bulan] ?? '01';
    }
}