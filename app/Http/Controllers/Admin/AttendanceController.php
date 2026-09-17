<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\PetugasAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $currentYear = $today->year;
        $currentMonthKey = $today->format('m-Y');
        $currentWeekOfMonth = (int) ceil($today->day / 7);
        $currentWeekLabel = sprintf('Minggu %d', $currentWeekOfMonth);

        $totalCount = AttendanceRecord::count();
        $weeklyCount = AttendanceRecord::query()
            ->get()
            ->filter(fn ($record) => $this->deriveWeekLabelFromDate($record->record_date ?? null) === $currentWeekLabel)
            ->count();
        $monthlyCount = AttendanceRecord::where('month_key', $currentMonthKey)->count();
        $yearlyCount = AttendanceRecord::where('year_key', (string) $currentYear)->count();
        $recentRecords = AttendanceRecord::latest()->take(10)->get();

        $petugasColumns = ['nama', 'nta', 'kelas_petugas', 'is_active'];
        if (Schema::hasColumn('petugas_absensis', 'status')) {
            $petugasColumns[] = 'status';
        }

        $registeredPetugas = PetugasAbsensi::query()
            ->select($petugasColumns)
            ->get()
            ->keyBy('nta');

        if ($registeredPetugas->isEmpty()) {
            $petugasSummary = collect();
        } else {
            $petugasSummary = AttendanceRecord::query()
                ->select('petugas_name', 'petugas_nta', 'petugas_kelas')
                ->selectRaw('MAX(created_at) AS last_seen')
                ->selectRaw('COUNT(DISTINCT record_date) AS total_records')
                ->groupBy('petugas_name', 'petugas_nta', 'petugas_kelas')
                ->orderByDesc('last_seen')
                ->get()
                ->map(function ($record) use ($registeredPetugas) {
                    $lastSeen = Carbon::parse($record->last_seen);
                    $registered = $registeredPetugas->get($record->petugas_nta)
                        ?? $registeredPetugas->first(function ($petugas) use ($record) {
                            return strtolower(trim((string) $petugas->nama)) === strtolower(trim((string) $record->petugas_name));
                        });

                    if (! $registered) {
                        return null;
                    }

                    $isActive = (bool) $registered->is_active;

                    return [
                        'name' => $record->petugas_name,
                        'nta' => $record->petugas_nta,
                        'kelas' => $record->petugas_kelas,
                        'last_seen' => $lastSeen->translatedFormat('d F Y H:i'),
                        'total_records' => (int) $record->total_records,
                        'status' => $isActive ? 'Aktif' : 'Non-Aktif',
                    ];
                })
                ->filter()
                ->values();
        }

        // Rekap agregat per tanggal + kelas + petugas
        $recapRecords = AttendanceRecord::query()
            ->select('record_date', 'participant_kelas', 'participant_sangga', 'participant_ambalan', 'petugas_name', 'week_label')
            ->selectRaw('COUNT(*) as total_members')
            ->selectRaw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir")
            ->selectRaw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as izin")
            ->selectRaw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as sakit")
            ->selectRaw("SUM(CASE WHEN status IN ('Alpha','Alpa','-','') THEN 1 ELSE 0 END) as alpha")
            ->groupBy('record_date', 'participant_kelas', 'participant_sangga', 'participant_ambalan', 'petugas_name', 'week_label')
            ->orderByDesc('record_date')
            ->get()
            ->map(function ($r) {
                return [
                    'record_date' => $r->record_date,
                    'kelas' => $r->participant_kelas,
                    'sangga' => $r->participant_sangga ?? '-',
                    'ambalan' => $r->participant_ambalan,
                    'petugas' => $r->petugas_name,
                    'total_members' => (int) $r->total_members,
                    'hadir' => (int) $r->hadir,
                    'izin' => (int) $r->izin,
                    'sakit' => (int) $r->sakit,
                    'alpha' => (int) $r->alpha,
                    'status' => ((int) $r->hadir > 0 ? 'Selesai' : 'Belum'),
                    'minggu_ke' => $this->deriveWeekLabelFromDate($r->record_date ?? null, $r->week_label ?? null),
                ];
            });

        return view('admin.absensi', [
            'totalCount' => $totalCount,
            'weeklyCount' => $weeklyCount,
            'monthlyCount' => $monthlyCount,
            'yearlyCount' => $yearlyCount,
            'recentRecords' => $recentRecords,
            'petugasSummary' => $petugasSummary,
            'recapRecords' => $recapRecords,
            'currentWeekLabel' => $currentWeekLabel,
            'currentMonthKey' => $currentMonthKey,
            'currentYear' => $currentYear,
        ]);
    }

    private function deriveWeekLabelFromDate(?string $recordDate, ?string $fallback = null): string
    {
        if (! empty($recordDate)) {
            try {
                $date = Carbon::parse($recordDate);

                return sprintf('Minggu %d', (int) ceil($date->day / 7));
            } catch (\Throwable $e) {
                // fallback below
            }
        }

        if (! empty($fallback) && preg_match('/Minggu\s*(\d+)/i', $fallback, $matches)) {
            return sprintf('Minggu %d', (int) $matches[1]);
        }

        return 'Minggu 0';
    }

    public function detail(Request $request)
    {
        $recordDate = $request->query('record_date');
        $participantKelas = $request->query('participant_kelas');
        $participantAmbalan = $request->query('participant_ambalan');
        $petugasName = $request->query('petugas_name');

        if (! $recordDate || ! $participantKelas || ! $participantAmbalan || ! $petugasName) {
            return redirect()->route('admin.absensi')->with('error', 'Detail absensi tidak ditemukan.');
        }

        $records = $this->detailRecords($request);

        return view('admin.absensi-detail', [
            'recordDate' => $recordDate,
            'participantKelas' => $participantKelas,
            'participantAmbalan' => $participantAmbalan,
            'petugasName' => $petugasName,
            'records' => $records,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $records = $this->detailRecords($request);
        $recordDate = $request->query('record_date', '');
        $participantKelas = $request->query('participant_kelas', '');
        $participantAmbalan = $request->query('participant_ambalan', '');
        $petugasName = $request->query('petugas_name', '');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Detail Absensi');

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', sprintf('Detail Absensi - %s', $recordDate ?: 'Semua Data'));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        $headers = ['Nama Lengkap', 'Kelas Asal', 'Ambalan', 'Sangga', 'Keterangan', 'Iuran', 'Nominal Iuran'];
        $sheet->fromArray([$headers], null, 'A3');
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);
        $sheet->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9EAF7');

        $rows = $records->map(function ($record) {
            return [
                $record->participant_name,
                $record->participant_kelas,
                $record->participant_ambalan,
                $record->participant_sangga ?? '-',
                $record->status,
                $record->iuran ?? '-',
                (int) ($record->iuran_amount ?? 0),
            ];
        })->toArray();

        if (empty($rows)) {
            $rows = [[
                'Tidak ada data absensi untuk filter ini.',
                '',
                '',
                '',
                '',
                '',
                '',
            ]];
        }

        $sheet->fromArray($rows, null, 'A4');

        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = sprintf('detail-absensi-%s-%s-%s.xlsx', $recordDate, str_replace([' ', '/'], ['-', '-'], $participantAmbalan), preg_replace('/[^A-Za-z0-9]/', '-', strtolower($petugasName)));

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->detailRecords($request);
        $recordDate = $request->query('record_date', '');
        $participantKelas = $request->query('participant_kelas', '');
        $participantAmbalan = $request->query('participant_ambalan', '');
        $petugasName = $request->query('petugas_name', '');

        $lines = [
            'DETAIL ABSENSI',
            'Tanggal: '.$recordDate,
            'Kelas: '.$participantKelas,
            'Ambalan: '.$participantAmbalan,
            'Petugas: '.$petugasName,
            '',
            'Nama Lengkap | Kelas | Ambalan | Sangga | Keterangan | Iuran',
        ];

        if ($records->isEmpty()) {
            $lines[] = 'Tidak ada data absensi untuk filter ini.';
        } else {
            foreach ($records as $record) {
                $amount = (int) ($record->iuran_amount ?? 0);
                $iuranLabel = $amount > 0 ? 'Rp '.number_format($amount, 0, ',', '.') : 'Belum bayar';
                $lines[] = sprintf('%s | %s | %s | %s | %s | %s',
                    $record->participant_name,
                    $record->participant_kelas,
                    $record->participant_ambalan,
                    $record->participant_sangga ?? '-',
                    $record->status,
                    $iuranLabel,
                );
            }
        }

        $pdf = $this->buildSimplePdf($lines);
        $filename = sprintf('detail-absensi-%s.pdf', $recordDate);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    private function detailRecords(Request $request)
    {
        $recordDate = $request->query('record_date');
        $participantKelas = $request->query('participant_kelas');
        $participantAmbalan = $request->query('participant_ambalan');
        $petugasName = $request->query('petugas_name');

        if (! $recordDate || ! $participantKelas || ! $participantAmbalan || ! $petugasName) {
            return collect();
        }

        return AttendanceRecord::query()
            ->where('record_date', $recordDate)
            ->where('participant_kelas', $participantKelas)
            ->where('participant_ambalan', $participantAmbalan)
            ->where('petugas_name', $petugasName)
            ->orderBy('participant_name')
            ->get();
    }

    private function buildSimplePdf(array $lines): string
    {
        $content = "BT\n/F1 10 Tf\n50 790 Td\n";
        $y = 790;

        foreach ($lines as $line) {
            $safeLine = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], (string) $line);
            $content .= sprintf("50 %d Td\n(%s) Tj\n", $y, $safeLine);
            $y -= 16;
        }

        $content .= "ET\n";

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Length ' . strlen($content) . ' >>' . "\nstream\n{$content}\nendstream",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1) . " 0 obj\n" . $object . "\nendobj\n";
        }

        $xrefPosition = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xrefPosition}\n%%EOF";

        return $pdf;
    }
}
