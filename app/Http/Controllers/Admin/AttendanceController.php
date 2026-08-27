<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\PetugasAbsensi;
use App\Models\Attendance;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Helper internal untuk mengonversi input UI 'Ya'/'Tidak' atau angka menjadi nominal Rupiah.
     */
    private function parseNominalIuran($val): int
    {
        if (is_bool($val)) {
            return $val ? 2000 : 0;
        }

        if (is_numeric($val)) {
            $num = (int) $val;
            return $num > 1 ? $num : ($num === 1 ? 2000 : 0);
        }

        $cleanVal = strtolower(trim((string) $val));
        if (in_array($cleanVal, ['ya', 'y', '1', 'true', 'ada'])) {
            return 2000; // Standar nominal iuran Rp 2.000
        }

        // Tangani string terformat seperti "Rp 2.000" atau "2.000"
        $digitsOnly = preg_replace('/[^\d]/', '', $cleanVal);
        if (!empty($digitsOnly) && is_numeric($digitsOnly)) {
            return (int) $digitsOnly;
        }

        return 0;
    }

    /**
     * Helper internal untuk mengonversi nama bulan bahasa Indonesia ke nomor bulan.
     */
    private function parseMonthToNumber($monthInput): string
    {
        $months = [
            'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
            'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
            'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12'
        ];

        $clean = strtolower(trim((string) $monthInput));
        return $months[$clean] ?? sprintf('%02d', (int) $monthInput);
    }

    /**
     * Halaman Utama / Summary Absensi
     */
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $today = Carbon::today();
        $currentYear = $today->year;
        $currentMonthKey = $today->format('m-Y');
        $currentWeekLabel = sprintf('Minggu %02d %s %s', $today->isoWeek(), $today->translatedFormat('F'), $today->year);

        $totalCount = AttendanceRecord::count();
        $weeklyCount = AttendanceRecord::where('week_label', $currentWeekLabel)->count();
        $monthlyCount = AttendanceRecord::where('month_key', $currentMonthKey)->count();
        $yearlyCount = AttendanceRecord::where('year_key', (string) $currentYear)->count();
        $recentRecords = AttendanceRecord::latest()->take(10)->get();

        $petugasSummary = AttendanceRecord::query()
            ->select('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->selectRaw('MAX(created_at) AS last_seen')
            ->selectRaw('COUNT(*) AS total_records')
            ->groupBy('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->orderByDesc('last_seen')
            ->get()
            ->map(function ($record) {
                $lastSeen = Carbon::parse($record->last_seen)->locale('id');
                $activeThreshold = now()->subDays(14);

                return [
                    'name'          => $record->petugas_name,
                    'nta'           => $record->petugas_nta,
                    'kelas'         => $record->petugas_kelas,
                    'last_seen'     => $lastSeen->translatedFormat('d F Y H:i'),
                    'total_records' => $record->total_records,
                    'status'        => $lastSeen->greaterThan($activeThreshold) ? 'Aktif' : 'Tidak Aktif',
                ];
            });

        // Rekap agregat per tanggal + kelas + ambalan + petugas
        $recapRecords = AttendanceRecord::query()
            ->select(
                'record_date', 
                'participant_kelas', 
                DB::raw('TRIM(participant_ambalan) as participant_ambalan'), 
                'petugas_name'
            )
            ->selectRaw('COUNT(*) as total_members')
            ->selectRaw("SUM(CASE WHEN LOWER(status) = 'hadir' THEN 1 ELSE 0 END) as hadir")
            ->selectRaw("SUM(CASE WHEN LOWER(status) = 'izin' THEN 1 ELSE 0 END) as izin")
            ->selectRaw("SUM(CASE WHEN LOWER(status) = 'sakit' THEN 1 ELSE 0 END) as sakit")
            ->selectRaw("SUM(CASE WHEN LOWER(status) IN ('alpha','alpa','-','') OR status IS NULL THEN 1 ELSE 0 END) as alpha")
            ->groupBy('record_date', 'participant_kelas', DB::raw('TRIM(participant_ambalan)'), 'petugas_name')
            ->orderByDesc('record_date')
            ->get()
            ->map(function ($r) {
                return [
                    'record_date'   => $r->record_date,
                    'kelas'         => trim($r->participant_kelas),
                    'ambalan'       => filled($r->participant_ambalan) ? trim($r->participant_ambalan) : '-',
                    'petugas'       => $r->petugas_name ?? 'Petugas',
                    'total_members' => (int) $r->total_members,
                    'hadir'         => (int) $r->hadir,
                    'izin'          => (int) $r->izin,
                    'sakit'         => (int) $r->sakit,
                    'alpha'         => (int) $r->alpha,
                    'status'        => ((int) $r->hadir > 0 ? 'Selesai' : 'Belum'),
                ];
            });

        return view('admin.absensi', [
            'totalCount'       => $totalCount,
            'weeklyCount'      => $weeklyCount,
            'monthlyCount'     => $monthlyCount,
            'yearlyCount'      => $yearlyCount,
            'recentRecords'    => $recentRecords,
            'petugasSummary'   => $petugasSummary,
            'petugasList'      => PetugasAbsensi::latest()->get(),
            'recapRecords'     => $recapRecords,
            'currentWeekLabel' => $currentWeekLabel,
            'currentMonthKey'  => $currentMonthKey,
            'currentYear'      => $currentYear,
        ]);
    }

    /**
     * Method Penyimpanan Data Absensi dari Form Input
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas'          => 'required|string',
            'ambalan'        => 'required|string',
            'peserta'        => 'required|array',
            'peserta.*.nama' => 'required|string',
        ]);

        $ambalanClean = trim($request->ambalan);
        $kelasClean   = trim($request->kelas);

        $tahun    = $request->input('tahun', date('Y'));
        $bulanStr = $request->input('bulan', date('m'));
        $bulan    = $this->parseMonthToNumber($bulanStr);
        $tanggal  = sprintf('%02d', (int) $request->input('tanggal', date('d')));

        $recordDate = "{$tahun}-{$bulan}-{$tanggal}";

        try {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $recordDate);
        } catch (\Exception $e) {
            $carbonDate = Carbon::now();
            $recordDate = $carbonDate->format('Y-m-d');
        }

        DB::transaction(function () use ($request, $recordDate, $carbonDate, $ambalanClean, $kelasClean) {
            foreach ($request->peserta as $item) {
                $nominal = $this->parseNominalIuran($item['iuran'] ?? 'Tidak');

                $statusMap = [
                    'H' => 'Hadir',
                    'I' => 'Izin',
                    'S' => 'Sakit',
                    'A' => 'Alpha',
                ];
                $statusInput = strtoupper(trim($item['keterangan'] ?? 'A'));
                $statusFix   = $statusMap[$statusInput] ?? ($item['keterangan'] ?? 'Alpha');

                AttendanceRecord::create([
                    'record_date'         => $recordDate,
                    'week_label'          => sprintf('Minggu %02d %s %s', $carbonDate->isoWeek(), $carbonDate->locale('id')->translatedFormat('F'), $carbonDate->year),
                    'month_key'           => $carbonDate->format('m-Y'),
                    'year_key'            => (string) $carbonDate->year,
                    'participant_name'    => trim($item['nama'] ?? ''),
                    'participant_kelas'   => $kelasClean,
                    'participant_ambalan' => $ambalanClean,
                    'status'              => $statusFix,
                    'iuran'               => $nominal,
                    'nominal_iuran'       => $nominal,
                    'petugas_name'        => auth()->user()->name ?? $request->input('petugas_name', 'Petugas'),
                    'petugas_kelas'       => auth()->user()->kelas ?? $request->input('petugas_kelas', '-'),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan!');
    }

    /**
     * Fetch Rincian Data Peserta & Iuran untuk Modal AJAX (REVISED)
     */
    public function getDetailData(Request $request)
    {
        try {
            Carbon::setLocale('id');

            // 1. Tangkap parameter & bersihkan spasi
            $rawDate = trim((string) ($request->input('date') ?? $request->input('record_date') ?? $request->input('tanggal') ?? ''));
            $kelas   = trim((string) ($request->input('kelas') ?? $request->input('participant_kelas') ?? ''));
            $ambalan = trim((string) ($request->input('ambalan') ?? $request->input('participant_ambalan') ?? ''));

            $query = AttendanceRecord::query();

            // 2. Normalisasi Tanggal ke YYYY-MM-DD
            if (filled($rawDate)) {
                try {
                    $formattedDate = Carbon::parse($rawDate)->format('Y-m-d');
                    $query->where(function ($q) use ($formattedDate, $rawDate) {
                        $q->where('record_date', $formattedDate)
                          ->orWhere('record_date', $rawDate)
                          ->orWhereRaw("DATE(created_at) = ?", [$formattedDate]);
                    });
                } catch (\Exception $e) {
                    $query->where('record_date', $rawDate);
                }
            }

            // 3. Filter Kelas (Case-insensitive & Bebas Spasi Tambahan)
            if (filled($kelas)) {
                $query->whereRaw('LOWER(TRIM(participant_kelas)) = ?', [strtolower($kelas)]);
            }

            // 4. Filter Ambalan (Jika bukan '-')
            if (filled($ambalan) && $ambalan !== '-') {
                $query->whereRaw('LOWER(TRIM(participant_ambalan)) = ?', [strtolower($ambalan)]);
            }

            $records = $query->get();

            // Fallback: Jika pencarian tanggal spesifik kosong, cari berdasarkan kelas & ambalan
            if ($records->isEmpty() && filled($kelas)) {
                $fallbackQuery = AttendanceRecord::whereRaw('LOWER(TRIM(participant_kelas)) = ?', [strtolower($kelas)]);
                if (filled($ambalan) && $ambalan !== '-') {
                    $fallbackQuery->whereRaw('LOWER(TRIM(participant_ambalan)) = ?', [strtolower($ambalan)]);
                }
                if (filled($rawDate)) {
                    $fallbackQuery->where(function($q) use ($rawDate) {
                        $q->where('record_date', 'LIKE', "%{$rawDate}%")
                          ->orWhere('created_at', 'LIKE', "%{$rawDate}%");
                    });
                }
                $fallbackRecords = $fallbackQuery->get();
                if ($fallbackRecords->isNotEmpty()) {
                    $records = $fallbackRecords;
                }
            }

            // 5. Formatkan Output JSON Lengkap
            $peserta = $records->map(function ($r) {
                $nominal = $this->parseNominalIuran($r->nominal_iuran ?? $r->iuran ?? 0);
                $status  = $r->status ?? $r->keterangan ?? 'Alpha';
                $nama    = $r->participant_name ?? $r->nama ?? $r->student_name ?? 'Tanpa Nama';

                return [
                    'id'                   => $r->id,
                    'nama'                 => $nama,
                    'participant_name'     => $nama,
                    'status'               => $status,
                    'keterangan'           => $status,
                    'iuran'                => $nominal,
                    'uang_iuran'           => $nominal,
                    'uang_iuran_formatted' => 'Rp ' . number_format($nominal, 0, ',', '.'),
                ];
            });

            return response()->json([
                'success'     => true,
                'count'       => $peserta->count(),
                'total_iuran' => $peserta->sum('iuran'),
                'peserta'     => $peserta,
                'data'        => $peserta,
                'details'     => $peserta,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error Server: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show Detail Single ID
     */
    public function show($id)
    {
        try {
            Carbon::setLocale('id');
            $attendance = AttendanceRecord::find($id);

            if (! $attendance) {
                return response()->json(['success' => false, 'message' => 'Data ID ' . $id . ' tidak ditemukan.'], 404);
            }

            $participants = [];
            $totalIuran = 0;
            $totalHadir = 0;

            if (method_exists($attendance, 'details') && $attendance->details()->count() > 0) {
                $totalIuran = $attendance->details->sum(fn($d) => $this->parseNominalIuran($d->nominal_iuran ?? $d->iuran));
                $totalHadir = $attendance->details->where('status', 'Hadir')->count();

                foreach ($attendance->details as $item) {
                    $nominal = $this->parseNominalIuran($item->nominal_iuran ?? $item->iuran);
                    $participants[] = [
                        'nama'       => $item->nama_peserta ?? $item->nama ?? 'Anggota',
                        'kelas'      => $item->kelas ?? '-',
                        'status'     => $item->status ?? 'Hadir',
                        'keterangan' => $item->status ?? 'Hadir',
                        'iuran'      => $nominal,
                        'uang_iuran' => $nominal,
                    ];
                }
            } else {
                $totalIuran = $this->parseNominalIuran($attendance->nominal_iuran ?? $attendance->iuran ?? 0);
                $totalHadir = strtolower($attendance->status ?? 'hadir') === 'hadir' ? 1 : 0;

                $participants[] = [
                    'nama'       => $attendance->participant_name ?? $attendance->nama ?? $attendance->petugas ?? 'Anggota',
                    'kelas'      => $attendance->participant_kelas ?? $attendance->kelas ?? '-',
                    'status'     => $attendance->status ?? 'Hadir',
                    'keterangan' => $attendance->status ?? 'Hadir',
                    'iuran'      => $totalIuran,
                    'uang_iuran' => $totalIuran,
                ];
            }

            return response()->json([
                'success'       => true,
                'kegiatan'      => $attendance->kegiatan ?? 'Absensi Kegiatan',
                'tanggal'       => $attendance->created_at ? $attendance->created_at->locale('id')->translatedFormat('d F Y - H:i') : '-',
                'petugas'       => $attendance->petugas_name ?? $attendance->petugas ?? 'Admin',
                'total_iuran'   => $totalIuran,
                'total_hadir'   => $totalHadir,
                'total_peserta' => count($participants),
                'participants'  => $participants,
                'data'          => $participants,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Server: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Export Data ke Excel (.xls)
     */
    public function exportExcel(Request $request)
    {
        Carbon::setLocale('id');
        $date    = trim((string) $request->query('date', ''));
        $kelas   = trim((string) $request->query('kelas', ''));
        $ambalan = trim((string) $request->query('ambalan', ''));

        $query = AttendanceRecord::query();

        if (filled($date)) {
            $query->where('record_date', $date);
        }

        if (filled($kelas)) {
            $query->where('participant_kelas', $kelas);
        }

        if (filled($ambalan) && $ambalan !== '-') {
            $query->whereRaw('LOWER(TRIM(participant_ambalan)) = ?', [strtolower($ambalan)]);
        }

        $records = $query->get();

        $totalUang = $records->sum(fn($r) => $this->parseNominalIuran($r->nominal_iuran ?? $r->iuran));

        $formattedDate = $date ? Carbon::parse($date)->format('d-m-Y') : date('d-m-Y');
        $ambalanText   = ($ambalan && $ambalan !== '-') ? " {$ambalan}" : "";
        $kelasText     = $kelas ? " Kelas {$kelas}" : "";
        $fileName      = "Absensi{$ambalanText}{$kelasText} {$formattedDate}.xls";

        return response()
            ->view('admin.exports.kas_excel', compact('records', 'date', 'kelas', 'ambalan', 'totalUang'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
    }

    /**
     * Export Laporan ke Word (.docx)
     */
    public function exportWord(Request $request = null, $id = null)
    {
        $request = $request ?? request();

        if (ob_get_level()) {
            ob_end_clean();
        }

        $absensi    = null;
        $tglAbsensi = null;

        if ($id && class_exists(Attendance::class)) {
            $absensi = Attendance::with('details')->find($id);
            if ($absensi) {
                $tglAbsensi = isset($absensi->tanggal) ? ("{$absensi->tanggal} {$absensi->bulan} {$absensi->tahun}") : null;
            }
        }

        if (!$absensi) {
            $date    = $request->query('date');
            $kelas   = $request->query('kelas');
            $ambalan = $request->query('ambalan');

            if ($id && !$date && !$kelas && !$ambalan) {
                $record = AttendanceRecord::find($id);
                if ($record) {
                    $date    = $record->record_date;
                    $kelas   = $record->participant_kelas;
                    $ambalan = $record->participant_ambalan;
                }
            }

            if (!$date || !$kelas) {
                abort(404, 'Absensi session not specified');
            }

            $rows = AttendanceRecord::query()
                ->where('record_date', $date)
                ->where('participant_kelas', $kelas)
                ->when($ambalan && $ambalan !== '-', fn($q) => $q->whereRaw('LOWER(TRIM(participant_ambalan)) = ?', [strtolower(trim($ambalan))]))
                ->get();

            if ($rows->isEmpty()) {
                abort(404, 'Absensi not found');
            }

            $details = $rows->map(fn($r) => (object) [
                'student_name' => $r->participant_name ?? $r->nama ?? null,
                'nama'         => $r->participant_name ?? $r->nama ?? null,
                'keterangan'   => $r->status ?? null,
                'iuran'        => $r->iuran ?? $r->nominal_iuran ?? 0,
                'uang_iuran'   => $r->nominal_iuran ?? $r->iuran ?? 0,
            ]);

            $totalIuran = $details->sum(fn($d) => $this->parseNominalIuran($d->uang_iuran ?? 0));

            $absensi = (object) [
                'tanggal'     => $date,
                'bulan'       => '',
                'tahun'       => '',
                'kelas'       => $kelas,
                'ambalan'     => $ambalan ?? '-',
                'total_iuran' => $totalIuran,
                'details'     => $details,
            ];

            $tglAbsensi = $date ? Carbon::parse($date)->locale('id')->translatedFormat('d F Y') : '-';
        }

        $tglRealtime = Carbon::now()->locale('id')->translatedFormat('d F Y');

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);

        $sectionStyle = [
            'pageSizeW'    => 21 * 567,
            'pageSizeH'    => 33 * 567,
            'marginTop'    => 2.54 * 567,
            'marginBottom' => 2.54 * 567,
            'marginLeft'   => 2.54 * 567,
            'marginRight'  => 2.54 * 567,
        ];

        $section = $phpWord->addSection($sectionStyle);

        $titleFont  = ['name' => 'Times New Roman', 'size' => 14, 'bold' => true];
        $boldFont   = ['name' => 'Times New Roman', 'size' => 12, 'bold' => true];
        $normalFont = ['name' => 'Times New Roman', 'size' => 12];
        $pCenter    = ['alignment' => Jc::CENTER, 'lineSpacing' => 360, 'spaceAfter' => 200];
        $p15        = ['lineSpacing' => 360, 'spaceAfter' => 100];
        $pCell      = ['lineSpacing' => 360, 'spaceAfter' => 0];

        $section->addText('LAPORAN ABSENSI & IURAN PRAMUKA', $titleFont, $pCenter);
        $section->addText("TANGGAL ABSENSI: {$tglAbsensi}", $titleFont, $pCenter);
        $section->addText("(Dicetak Real-Time: {$tglRealtime})", ['size' => 10, 'italic' => true], ['alignment' => Jc::CENTER, 'lineSpacing' => 360, 'spaceAfter' => 240]);

        $section->addText("Kelas                   : {$absensi->kelas}", $normalFont, $p15);
        $section->addText("Ambalan                 : {$absensi->ambalan}", $normalFont, $p15);

        $totalIuranFormatted = 'Rp ' . number_format($absensi->total_iuran ?? 0, 0, ',', '.');
        $section->addText("Total Uang Iuran        : {$totalIuranFormatted}", $boldFont, ['lineSpacing' => 360, 'spaceAfter' => 240]);

        $tableStyle = [
            'borderSize'       => 6,
            'borderColor'      => '000000',
            'cellMarginTop'    => 100,
            'cellMarginBottom' => 100,
            'cellMarginLeft'   => 150,
            'cellMarginRight'  => 150,
            'alignment'        => Jc::CENTER,
        ];
        $phpWord->addTableStyle('AbsensiModalTable', $tableStyle);
        $table = $section->addTable('AbsensiModalTable');

        $table->addRow();
        $table->addCell(800)->addText('No', $boldFont, $pCell);
        $table->addCell(4500)->addText('Nama Peserta', $boldFont, $pCell);
        $table->addCell(2000)->addText('Keterangan', $boldFont, $pCell);
        $table->addCell(2200)->addText('Uang Iuran', $boldFont, $pCell);

        $no = 1;
        foreach ($absensi->details as $item) {
            $table->addRow();
            $table->addCell(800)->addText($no++, $normalFont, $pCell);
            $name = strtoupper($item->student_name ?? $item->nama ?? $item->name ?? '-');
            $table->addCell(4500)->addText($name, $normalFont, $pCell);
            $table->addCell(2000)->addText($item->keterangan ?? $item->status ?? '-', $normalFont, $pCell);

            $nominalItem = $this->parseNominalIuran($item->uang_iuran ?? $item->iuran ?? 0);
            $iuranText   = $nominalItem > 0 ? 'Rp ' . number_format($nominalItem, 0, ',', '.') : 'Rp 0';
            $table->addCell(2200)->addText($iuranText, $normalFont, $pCell);
        }

        $filename = 'Rincian_Absensi_' . Str::slug($absensi->kelas ?? 'kelas') . '_' . Str::slug($absensi->ambalan ?? 'ambalan') . '.docx';

        $tempFile = tempnam(sys_get_temp_dir(), 'word_absensi_');
        $writer   = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}