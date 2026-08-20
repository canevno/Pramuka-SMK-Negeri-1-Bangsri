<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    // 1. Tampilan FRONT-END (Siswa / Publik)
    public function index(Request $request)
    {
        $selectedAmbalan = $request->query('ambalan');
        $selectedKelas = $request->query('kelas');

        $query = Student::query();

        if (in_array($selectedAmbalan, ['Putra', 'Putri'])) {
            $query->where('ambalan', $selectedAmbalan);
        }

        if (filled($selectedKelas)) {
            $query->where('kelas', $selectedKelas);
        }

        $students = $query->get();

        $roster = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'nama' => $student->nama,
                'name' => $student->nama,
                'kelas' => $student->kelas,
                'ambalan' => $student->ambalan,
            ];
        })->all();

        // Mengarah ke FRONT-END View
        return view('pages.absensi', [
            'roster' => $roster,
            'students' => $students,
            'selectedAmbalan' => $selectedAmbalan,
            'selectedKelas' => $selectedKelas,
        ]);
    }

    // 2. Tampilan ADMIN (Dashboard Admin)
    public function adminIndex(Request $request)
    {
        $selectedAmbalan = $request->query('ambalan');
        $selectedKelas = $request->query('kelas');

        $query = Student::query();

        if (in_array($selectedAmbalan, ['Putra', 'Putri'])) {
            $query->where('ambalan', $selectedAmbalan);
        }

        if (filled($selectedKelas)) {
            $query->where('kelas', $selectedKelas);
        }

        $students = $query->get();

        $roster = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'nama' => $student->nama,
                'name' => $student->nama,
                'kelas' => $student->kelas,
                'ambalan' => $student->ambalan,
            ];
        })->all();

        // Mengarah ke ADMIN View
        return view('admin.absensi', [
            'roster' => $roster,
            'students' => $students,
            'selectedAmbalan' => $selectedAmbalan,
            'selectedKelas' => $selectedKelas,
        ]);
    }

    public function submit(Request $request)
    {
        if (! $request->session()->has('absensi_verified')) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Silakan verifikasi terlebih dahulu.');
        }

        $statuses = $request->input('status', []);
        $participantNames = $request->input('participant_name', []);
        $participantKelas = trim((string) $request->input('participant_kelas', ''));
        $participantAmbalanForm = trim((string) $request->input('participant_ambalan', ''));
        $iurans = $request->input('iuran', []);
        $bulan = trim((string) $request->input('bulan', ''));
        $tanggal = trim((string) $request->input('tanggal', ''));
        $tahun = trim((string) $request->input('tahun', ''));

        if ($bulan === '' || $tanggal === '' || $tahun === '' || empty($statuses) || $participantKelas === '' || $participantAmbalanForm === '' || empty($iurans)) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Data absensi tidak lengkap.');
        }

        $validStudentIds = Student::query()
            ->where('kelas', $participantKelas)
            ->where('ambalan', $participantAmbalanForm)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $rows = [];
        $weekLabel = $this->generateWeekLabel($bulan, $tanggal, $tahun);
        $monthKey = $this->generateMonthKey($bulan, $tahun);
        $yearKey = (string) $tahun;
        $recordDate = $this->generateRecordDate($bulan, $tanggal, $tahun);

        foreach ($statuses as $id => $status) {
            $studentId = (string) $id;

            if (! filled($status)) {
                continue;
            }

            if (! in_array($studentId, $validStudentIds, true)) {
                continue;
            }

            $studentInfo = Student::where('id', $studentId)
                ->where('kelas', $participantKelas)
                ->where('ambalan', $participantAmbalanForm)
                ->first();

            if (! $studentInfo) {
                continue;
            }

            $rows[] = [
                'bulan' => $bulan,
                'tanggal' => $tanggal,
                'tahun' => $tahun,
                'participant_id' => $studentId,
                'participant_name' => trim((string) ($participantNames[$studentId] ?? $studentInfo->nama)),
                'participant_kelas' => $participantKelas,
                'participant_ambalan' => $participantAmbalanForm,
                'status' => (string) $status,
                'iuran' => trim((string) ($iurans[$studentId] ?? 'Tidak')),
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
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Tidak ada data peserta yang cocok untuk ambalan ini.');
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