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
                    $lastSeen = Carbon::parse($record->last_seen)->setTimezone('Asia/Jakarta');
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

        // Rekap agregat per tanggal + sub sangga + petugas, bukan per kelas peserta
        // Kelas tetap diambil dari data asli tiap siswa di detail, agar satu sub sangga tidak terpecah.
        $recapRecords = AttendanceRecord::query()
            ->select('record_date', 'participant_sangga', 'participant_ambalan', 'petugas_name', 'week_label')
            ->selectRaw('MAX(created_at) as last_saved_at')
            ->selectRaw('COUNT(*) as total_members')
            ->selectRaw('GROUP_CONCAT(DISTINCT participant_kelas ORDER BY participant_kelas SEPARATOR ", ") as kelas_list')
            ->selectRaw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir")
            ->selectRaw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as izin")
            ->selectRaw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as sakit")
            ->selectRaw("SUM(CASE WHEN status IN ('Alpha','Alpa','-','') THEN 1 ELSE 0 END) as alpha")
            ->groupBy('record_date', 'participant_sangga', 'participant_ambalan', 'petugas_name', 'week_label')
            ->orderByDesc('last_saved_at')
            ->orderByDesc('record_date')
            ->get()
            ->map(function ($r) {
                $groupKey = implode('|', [
                    (string) ($r->record_date ?? ''),
                    (string) ($r->participant_sangga ?? ''),
                    (string) ($r->participant_ambalan ?? ''),
                    (string) ($r->petugas_name ?? ''),
                ]);

                return [
                    'record_date' => $r->record_date,
                    'kelas' => $r->kelas_list ?: '-',
                    'sangga' => $r->participant_sangga ?? '-',
                    'ambalan' => $r->participant_ambalan,
                    'petugas' => $r->petugas_name,
                    'group_key' => $groupKey,
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
        $participantSangga = $request->query('participant_sangga');
        $participantAmbalan = $request->query('participant_ambalan');
        $petugasName = $request->query('petugas_name');

        if (! $recordDate || ! $participantAmbalan || ! $petugasName) {
            return redirect()->route('admin.absensi')->with('error', 'Detail absensi tidak ditemukan.');
        }

        $records = $this->detailRecords($request);

        return view('admin.absensi-detail', [
            'recordDate' => $recordDate,
            'participantKelas' => $participantKelas ?? ($records->first()?->participant_kelas ?? 'Berbagai Kelas'),
            'participantSangga' => $participantSangga ?? ($records->first()?->participant_sangga ?? 'Berbagai Sub Sangga'),
            'participantAmbalan' => $participantAmbalan,
            'petugasName' => $petugasName,
            'records' => $records,
        ]);
    }

    public function destroySelected(Request $request)
    {
        $selectedKeys = $request->input('selected_records', []);

        if (empty($selectedKeys)) {
            return redirect()->route('admin.absensi')->with('error', 'Pilih rekaman absensi yang ingin dihapus.');
        }

        $deleted = 0;

        foreach ($selectedKeys as $key) {
            $parts = array_map('trim', explode('|', (string) $key));
            if (count($parts) < 4) {
                continue;
            }

            [$recordDate, $participantSangga, $participantAmbalan, $petugasName] = $parts;

            $deleted += AttendanceRecord::query()
                ->where('record_date', $recordDate)
                ->where('participant_sangga', $participantSangga)
                ->where('participant_ambalan', $participantAmbalan)
                ->where('petugas_name', $petugasName)
                ->delete();
        }

        return redirect()->route('admin.absensi')->with('success', $deleted > 0 ? 'Rekaman absensi yang dipilih berhasil dihapus.' : 'Tidak ada rekaman absensi yang dihapus.');
    }

    public function destroyAll(Request $request)
    {
        $deleted = AttendanceRecord::query()->delete();

        return redirect()->route('admin.absensi')->with('success', 'Semua rekaman absensi berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $records = $this->detailRecords($request);
        $recordDate = $request->query('record_date', '');
        $participantKelas = $request->query('participant_kelas', '');
        $participantSangga = $request->query('participant_sangga', '');
        $participantAmbalan = $request->query('participant_ambalan', '');
        $petugasName = $request->query('petugas_name', '');

        if ($participantSangga === '') {
            $participantSangga = $records->first()?->participant_sangga ?? 'Berbagai Sub Sangga';
        }

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

        $sheet->setCellValue('A4', strtoupper((string) $participantSangga));
        $sheet->getStyle('A4')->getFont()->setBold(true)->setName('Times New Roman')->setSize(11);

        $monthDate = $recordDate !== '' ? Carbon::parse($recordDate) : Carbon::now();
        $monthWeekCount = (int) min(4, max(1, (int) ceil($monthDate->daysInMonth / 7)));
        $weekLabels = [];
        for ($week = 1; $week <= 4; $week++) {
            $weekLabels[] = $week <= $monthWeekCount ? 'M'.$week : '';
        }

        $headerRow = 5;
        $sheet->mergeCells('A'.$headerRow.':A'.($headerRow + 1));
        $sheet->mergeCells('B'.$headerRow.':B'.($headerRow + 1));
        $sheet->setCellValue('A'.$headerRow, 'Nama Lengkap');
        $sheet->setCellValue('B'.$headerRow, 'Kelas');

        $sheet->mergeCells('C'.$headerRow.':F'.$headerRow);
        $sheet->setCellValue('C'.$headerRow, strtoupper($monthDate->translatedFormat('F')));

        $weekColumns = ['C', 'D', 'E', 'F'];
        foreach ($weekColumns as $index => $column) {
            $sheet->setCellValue($column.($headerRow + 1), $weekLabels[$index] ?? '');
        }

        $sheet->mergeCells('G'.$headerRow.':I'.$headerRow);
        $sheet->setCellValue('G'.$headerRow, 'Jumlah');
        $sheet->setCellValue('G'.($headerRow + 1), 'A');
        $sheet->setCellValue('H'.($headerRow + 1), 'S');
        $sheet->setCellValue('I'.($headerRow + 1), 'I');

        $sheet->getStyle('A'.$headerRow.':I'.($headerRow + 1))->getFont()->setBold(true)->setName('Times New Roman');
        $sheet->getStyle('A'.$headerRow.':I'.($headerRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$headerRow.':I'.($headerRow + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $rows = $records->map(function ($record) {
            $status = strtoupper((string) ($record->status ?? ''));
            $a = $status === 'A' || $status === 'ALPHA' || $status === 'ALPA' ? 1 : 0;
            $s = $status === 'S' || $status === 'SAKIT' ? 1 : 0;
            $i = $status === 'I' || $status === 'IZIN' ? 1 : 0;
            $weekValue = match (true) {
                $status === 'HADIR' => 'H',
                $status === 'SAKIT' => 'S',
                $status === 'IZIN' => 'I',
                default => 'A',
            };

            $weekIndex = 0;
            if (! empty($record->record_date)) {
                try {
                    $weekIndex = (int) ceil(Carbon::parse($record->record_date)->day / 7) - 1;
                } catch (\Throwable $e) {
                    $weekIndex = 0;
                }
            }

            $weekCells = ['', '', '', ''];
            if ($weekIndex >= 0 && $weekIndex < 4) {
                $weekCells[$weekIndex] = $weekValue;
            }

            return [
                $record->participant_name,
                $record->participant_kelas,
                $weekCells[0],
                $weekCells[1],
                $weekCells[2],
                $weekCells[3],
                $a,
                $s,
                $i,
            ];
        })->toArray();

        if (empty($rows)) {
            $rows = [
                ['Aldi Pratama', 'X-1', 'H', '', '', '', 2, 0, 1],
                ['Bima Ardiansyah', 'X-2', '', 'A', '', '', 1, 1, 0],
                ['Candra Wijaya', 'XI-1', '', '', 'I', '', 1, 0, 1],
                ['Dewi Lestari', 'XI-2', '', '', '', 'H', 2, 0, 1],
                ['Eko Saputra', 'XII-1', 'H', '', '', '', 1, 1, 1],
            ];
        }

        $dataRow = $headerRow + 2;
        $sheet->fromArray($rows, null, 'A'.$dataRow);

        $lastRow = $dataRow + count($rows) - 1;
        $sheet->getStyle('A'.$dataRow.':I'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$dataRow.':I'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$dataRow.':A'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B'.$dataRow.':B'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setWidth(15);
        }

        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(10);

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
        $participantSangga = $request->query('participant_sangga', '');
        $participantAmbalan = $request->query('participant_ambalan', '');
        $petugasName = $request->query('petugas_name', '');

        if ($participantSangga === '') {
            $participantSangga = $records->first()?->participant_sangga ?? 'Berbagai Sub Sangga';
        }

        $monthDate = $recordDate !== '' ? Carbon::parse($recordDate) : Carbon::now();
        $monthWeekCount = (int) min(4, max(1, (int) ceil($monthDate->daysInMonth / 7)));
        $weekLabels = array_fill(0, 4, '');
        for ($week = 1; $week <= 4; $week++) {
            if ($week <= $monthWeekCount) {
                $weekLabels[$week - 1] = 'M'.$week;
            }
        }

        $rows = $records->map(function ($record) {
            $status = strtoupper((string) ($record->status ?? ''));
            $a = $status === 'A' || $status === 'ALPHA' || $status === 'ALPA' ? 1 : 0;
            $s = $status === 'S' || $status === 'SAKIT' ? 1 : 0;
            $i = $status === 'I' || $status === 'IZIN' ? 1 : 0;

            $weekValue = match (true) {
                $status === 'HADIR' => 'H',
                $status === 'SAKIT' => 'S',
                $status === 'IZIN' => 'I',
                default => 'A',
            };

            $weekIndex = 0;
            if (! empty($record->record_date)) {
                try {
                    $weekIndex = (int) ceil(Carbon::parse($record->record_date)->day / 7) - 1;
                } catch (\Throwable $e) {
                    $weekIndex = 0;
                }
            }

            $weekCells = ['', '', '', ''];
            if ($weekIndex >= 0 && $weekIndex < 4) {
                $weekCells[$weekIndex] = $weekValue;
            }

            return [
                $record->participant_name,
                $record->participant_kelas,
                $weekCells[0],
                $weekCells[1],
                $weekCells[2],
                $weekCells[3],
                $a,
                $s,
                $i,
            ];
        })->toArray();

        if (empty($rows)) {
            $rows = [
                ['Aldi Pratama', 'X-1', 'H', '', '', '', 2, 0, 1],
                ['Bima Ardiansyah', 'X-2', '', 'A', '', '', 1, 1, 0],
                ['Candra Wijaya', 'XI-1', '', '', 'I', '', 1, 0, 1],
                ['Dewi Lestari', 'XI-2', '', '', '', 'H', 2, 0, 1],
                ['Eko Saputra', 'XII-1', 'H', '', '', '', 1, 1, 1],
            ];
        }

        $pdf = $this->buildFormalAttendancePdf($rows, $participantKelas, $participantAmbalan, $petugasName, $participantSangga, $weekLabels, $monthDate);
        $filename = sprintf('detail-absensi-%s.pdf', $recordDate);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    private function detailRecords(Request $request)
    {
        $recordDate = $request->query('record_date');
        $participantAmbalan = $request->query('participant_ambalan');
        $petugasName = $request->query('petugas_name');

        if (! $recordDate || ! $participantAmbalan || ! $petugasName) {
            return collect();
        }

        $query = AttendanceRecord::query()
            ->where('record_date', $recordDate)
            ->where('participant_ambalan', $participantAmbalan)
            ->where('petugas_name', $petugasName);

        $participantSangga = $request->query('participant_sangga');
        if ($participantSangga) {
            $query->where('participant_sangga', $participantSangga);
        }

        return $query->orderBy('participant_name')->get();
    }

    private function buildFormalAttendancePdf(array $rows, string $participantKelas = '', string $participantAmbalan = '', string $petugasName = '', string $participantSangga = '', array $weekLabels = ['M1', 'M2', 'M3', 'M4'], Carbon|string|null $monthDate = null): string
    {
        $monthName = $monthDate instanceof Carbon ? $monthDate->translatedFormat('F') : Carbon::now()->translatedFormat('F');

        $content = "BT\n/F1 14 Tf\n180 790 Td\n(ABSENSI EXTRAKULIKULER PRAMUKA) Tj\nET\n";
        $content .= "BT\n/F1 12 Tf\n180 770 Td\n(SMK NEGERI 1 BANGSRI) Tj\nET\n";
        $content .= "BT\n/F1 11 Tf\n45 744 Td\n(" . $this->pdfEscape($participantSangga !== '' ? $participantSangga : 'Berbagai Sub Sangga') . ") Tj\nET\n";

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
        $colWidths = [190, 70, 44, 44, 44, 44, 36, 36, 36];

        $draw = function (float $xPos, float $yPos, float $width, float $height) use (&$content) {
            $content .= sprintf("%.2f %.2f %.2f %.2f re S\n", $xPos, $yPos, $width, $height);
        };

        $drawText = function (float $xPos, float $yPos, string $text, string $font = 'F2', float $size = 7) use (&$content) {
            $safe = $this->pdfEscape($text);
            $content .= "BT\n/$font {$size} Tf\n{$xPos} {$yPos} Td\n({$safe}) Tj\nET\n";
        };

        $headerY = $startY;
        $x = $startX;
        foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8] as $index) {
            $cellWidth = $colWidths[$index] ?? 36;
            $draw($x, $headerY, $cellWidth, 40);
            $x += $cellWidth;
        }

        $drawText($startX + 4, $headerY + 24, 'Nama Lengkap', 'F1', 7);
        $drawText($startX + 200, $headerY + 24, 'Kelas', 'F1', 7);
        $drawText($startX + 270, $headerY + 24, strtoupper($monthName), 'F1', 7);

        $bodyStartX = $startX + 260;
        $bodyHeaderY = $headerY - 20;
        $weekX = $bodyStartX;
        foreach ($weekLabels as $label) {
            $labelValue = $label !== '' ? $label : '';
            $drawText($weekX + 8, $bodyHeaderY + 20, $labelValue, 'F1', 7);
            $weekX += 44;
        }
        $drawText($weekX + 6, $bodyHeaderY + 20, 'A', 'F1', 7);
        $drawText($weekX + 42, $bodyHeaderY + 20, 'S', 'F1', 7);
        $drawText($weekX + 78, $bodyHeaderY + 20, 'I', 'F1', 7);

        $yPos = $startY - 40;
        foreach ($rows as $row) {
            $xPos = $startX;
            foreach ($row as $cellIndex => $cell) {
                $cellWidth = $colWidths[$cellIndex] ?? 36;
                $draw($xPos, $yPos, $cellWidth, $rowHeight);

                $value = (string) $cell;
                if ($cellIndex === 0) {
                    $drawText($xPos + 4, $yPos + 8, $value, 'F2', 7);
                } elseif ($cellIndex === 1) {
                    $drawText($xPos + 8, $yPos + 8, $value, 'F2', 7);
                } else {
                    $drawText($xPos + 10, $yPos + 8, $value, 'F2', 7);
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
