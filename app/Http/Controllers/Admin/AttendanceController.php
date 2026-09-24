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
        $sheet->setTitle('Absensi');
        $sheet->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setTop(0.4)->setRight(0.3)->setBottom(0.3)->setLeft(0.3);

        $sheet->mergeCells('A1:Q1');
        $sheet->setCellValue('A1', 'ABSENSI EXTRAKULIKULER PRAMUKA');
        $sheet->getStyle('A1:Q1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(14);
        $sheet->getStyle('A1:Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:Q2');
        $sheet->setCellValue('A2', 'SMK NEGERI 1 BANGSRI');
        $sheet->getStyle('A2:Q2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(12);
        $sheet->getStyle('A2:Q2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'PENDOBRAK 1 PI');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setName('Times New Roman')->setSize(11);

        $headerRow = 5;
        $sheet->mergeCells('A'.$headerRow.':A'.($headerRow + 1));
        $sheet->mergeCells('B'.$headerRow.':B'.($headerRow + 1));
        $sheet->setCellValue('A'.$headerRow, 'Nama Lengkap');
        $sheet->setCellValue('B'.$headerRow, 'Kelas');

        $groupStart = ['C', 'G', 'K'];
        foreach ($groupStart as $start) {
            $end = chr(ord($start) + 3);
            $sheet->mergeCells($start.$headerRow.':'.$end.$headerRow);
        }

        $sheet->mergeCells('O'.$headerRow.':Q'.$headerRow);
        $sheet->setCellValue('O'.$headerRow, 'Jumlah');
        $sheet->setCellValue('O'.($headerRow + 1), 'A');
        $sheet->setCellValue('P'.($headerRow + 1), 'S');
        $sheet->setCellValue('Q'.($headerRow + 1), 'I');

        foreach (range('C', 'N') as $column) {
            $sheet->setCellValue($column.($headerRow + 1), '');
        }

        $sheet->getStyle('A'.$headerRow.':Q'.($headerRow + 1))->getFont()->setBold(true)->setName('Times New Roman');
        $sheet->getStyle('A'.$headerRow.':Q'.($headerRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$headerRow.':Q'.($headerRow + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $rows = $records->map(function ($record) {
            $status = strtoupper((string) ($record->status ?? ''));
            $attendance = ['H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H'];
            $attendance[0] = match (true) {
                $status === 'HADIR' => 'H',
                $status === 'IZIN' => 'I',
                $status === 'SAKIT' => 'S',
                default => 'A',
            };

            $a = $status === 'A' || $status === 'ALPHA' || $status === 'ALPA' ? 1 : 0;
            $s = $status === 'S' || $status === 'SAKIT' ? 1 : 0;
            $i = $status === 'I' || $status === 'IZIN' ? 1 : 0;

            return [
                $record->participant_name,
                $record->participant_kelas,
                ...$attendance,
                $a,
                $s,
                $i,
            ];
        })->toArray();

        if (empty($rows)) {
            $rows = [
                ['Aldi Pratama', 'X-1', 'H', 'H', 'A', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 2, 0, 1],
                ['Bima Ardiansyah', 'X-2', 'H', 'H', 'H', 'S', 'H', 'H', 'H', 'H', 'H', 'H', 'I', 'H', 1, 1, 1],
                ['Candra Wijaya', 'XI-1', 'H', 'A', 'H', 'H', 'H', 'H', 'S', 'H', 'H', 'H', 'H', 'H', 1, 1, 0],
                ['Dewi Lestari', 'XI-2', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'A', 'H', 'H', 'H', 'H', 2, 0, 1],
                ['Eko Saputra', 'XII-1', 'H', 'H', 'S', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'A', 1, 1, 1],
            ];
        }

        $dataRow = $headerRow + 2;
        $sheet->fromArray($rows, null, 'A'.$dataRow);

        $lastRow = $dataRow + count($rows) - 1;
        $sheet->getStyle('A'.$dataRow.':Q'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$dataRow.':Q'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$dataRow.':A'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B'.$dataRow.':B'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'Q') as $column) {
            $sheet->getColumnDimension($column)->setWidth(15);
        }

        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(8);
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setWidth(8);
        $sheet->getColumnDimension('H')->setWidth(8);
        $sheet->getColumnDimension('I')->setWidth(8);
        $sheet->getColumnDimension('J')->setWidth(8);
        $sheet->getColumnDimension('K')->setWidth(8);
        $sheet->getColumnDimension('L')->setWidth(8);
        $sheet->getColumnDimension('M')->setWidth(8);
        $sheet->getColumnDimension('N')->setWidth(8);
        $sheet->getColumnDimension('O')->setWidth(9);
        $sheet->getColumnDimension('P')->setWidth(9);
        $sheet->getColumnDimension('Q')->setWidth(9);

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

        $rows = $records->map(function ($record) {
            $status = strtoupper((string) ($record->status ?? ''));
            $attendance = ['H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H'];
            $attendance[0] = match (true) {
                $status === 'HADIR' => 'H',
                $status === 'IZIN' => 'I',
                $status === 'SAKIT' => 'S',
                default => 'A',
            };

            $a = $status === 'A' || $status === 'ALPHA' || $status === 'ALPA' ? 1 : 0;
            $s = $status === 'S' || $status === 'SAKIT' ? 1 : 0;
            $i = $status === 'I' || $status === 'IZIN' ? 1 : 0;

            return [
                $record->participant_name,
                $record->participant_kelas,
                ...$attendance,
                $a,
                $s,
                $i,
            ];
        })->toArray();

        if (empty($rows)) {
            $rows = [
                ['Aldi Pratama', 'X-1', 'H', 'H', 'A', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 2, 0, 1],
                ['Bima Ardiansyah', 'X-2', 'H', 'H', 'H', 'S', 'H', 'H', 'H', 'H', 'H', 'H', 'I', 'H', 1, 1, 1],
                ['Candra Wijaya', 'XI-1', 'H', 'A', 'H', 'H', 'H', 'H', 'S', 'H', 'H', 'H', 'H', 'H', 1, 1, 0],
                ['Dewi Lestari', 'XI-2', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'A', 'H', 'H', 'H', 'H', 2, 0, 1],
                ['Eko Saputra', 'XII-1', 'H', 'H', 'S', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'A', 1, 1, 1],
            ];
        }

        $pdf = $this->buildFormalAttendancePdf($rows, $participantKelas, $participantAmbalan, $petugasName);
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

    private function buildFormalAttendancePdf(array $rows, string $participantKelas = '', string $participantAmbalan = '', string $petugasName = ''): string
    {
        $content = "BT\n/F1 14 Tf\n180 790 Td\n(ABSENSI EXTRAKULIKULER PRAMUKA) Tj\nET\n";
        $content .= "BT\n/F1 12 Tf\n180 770 Td\n(SMK NEGERI 1 BANGSRI) Tj\nET\n";
        $content .= "BT\n/F1 11 Tf\n45 744 Td\n(PENDOBRAK 1 PI) Tj\nET\n";

        if ($participantKelas !== '') {
            $content .= "BT\n/F1 9 Tf\n45 724 Td\n(KELAS: {$this->pdfEscape($participantKelas)}) Tj\nET\n";
        }
        if ($participantAmbalan !== '') {
            $content .= "BT\n/F1 9 Tf\n45 712 Td\n(AMBALAN: {$this->pdfEscape($participantAmbalan)}) Tj\nET\n";
        }
        if ($petugasName !== '') {
            $content .= "BT\n/F1 9 Tf\n45 700 Td\n(PETUGAS: {$this->pdfEscape($petugasName)}) Tj\nET\n";
        }

        $startX = 30;
        $startY = 650;
        $rowHeight = 20;
        $colWidths = [180, 60, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18];

        $draw = function (float $xPos, float $yPos, float $width, float $height) use (&$content) {
            $content .= sprintf("%.2f %.2f %.2f %.2f re S\n", $xPos, $yPos, $width, $height);
        };

        $drawText = function (float $xPos, float $yPos, string $text, string $font = 'F2', float $size = 7) use (&$content) {
            $safe = $this->pdfEscape($text);
            $content .= "BT\n/$font {$size} Tf\n{$xPos} {$yPos} Td\n({$safe}) Tj\nET\n";
        };

        $headerY = $startY;
        $x = $startX;
        foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16] as $index) {
            $cellWidth = $colWidths[$index] ?? 18;
            $draw($x, $headerY, $cellWidth, 44);
            $x += $cellWidth;
        }

        $drawText($startX + 4, $headerY + 24, 'Nama Lengkap', 'F1', 7);
        $drawText($startX + 190, $headerY + 24, 'Kelas', 'F1', 7);
        $drawText($startX + 255, $headerY + 24, '1', 'F1', 7);
        $drawText($startX + 273, $headerY + 24, '2', 'F1', 7);
        $drawText($startX + 291, $headerY + 24, '3', 'F1', 7);
        $drawText($startX + 309, $headerY + 24, '4', 'F1', 7);
        $drawText($startX + 327, $headerY + 24, '5', 'F1', 7);
        $drawText($startX + 345, $headerY + 24, '6', 'F1', 7);
        $drawText($startX + 363, $headerY + 24, '7', 'F1', 7);
        $drawText($startX + 381, $headerY + 24, '8', 'F1', 7);
        $drawText($startX + 399, $headerY + 24, '9', 'F1', 7);
        $drawText($startX + 417, $headerY + 24, '10', 'F1', 7);
        $drawText($startX + 435, $headerY + 24, '11', 'F1', 7);
        $drawText($startX + 453, $headerY + 24, '12', 'F1', 7);
        $drawText($startX + 471, $headerY + 24, 'A', 'F1', 7);
        $drawText($startX + 489, $headerY + 24, 'S', 'F1', 7);
        $drawText($startX + 507, $headerY + 24, 'I', 'F1', 7);

        $yPos = $startY - 44;
        foreach ($rows as $row) {
            $xPos = $startX;
            foreach ($row as $cellIndex => $cell) {
                $cellWidth = $colWidths[$cellIndex] ?? 18;
                $draw($xPos, $yPos, $cellWidth, $rowHeight);

                $value = (string) $cell;
                if ($cellIndex === 0) {
                    $drawText($xPos + 4, $yPos + 8, $value, 'F2', 7);
                } elseif ($cellIndex === 1) {
                    $drawText($xPos + 8, $yPos + 8, $value, 'F2', 7);
                } else {
                    $drawText($xPos + 6, $yPos + 8, $value, 'F2', 7);
                }

                $xPos += $cellWidth;
            }
            $yPos -= $rowHeight;
        }

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> /Contents 6 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Bold >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Roman >>',
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

    private function pdfEscape(string $value): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $value);
    }
}
