<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PetugasAbsensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DaftarPetugas extends Component
{
    // Properti untuk Form Input
    public $nama = '';
    public $nta = '';
    public $kelas_petugas = '';
    public $showModal = false;

    // Aturan Validasi
    protected $rules = [
        'nama'          => 'required|string|min:3',
        'nta'           => 'required|string|unique:petugas_absensis,nta',
        'kelas_petugas' => 'required|string',
    ];

    protected $messages = [
        'nta.unique' => 'NTA ini sudah terdaftar dalam sistem.',
    ];

    // Fungsi Simpan Petugas Baru
    public function simpanPetugas()
    {
        $this->validate();

        PetugasAbsensi::create([
            'nama'          => trim($this->nama),
            'nta'           => trim($this->nta),
            'kelas_petugas' => trim($this->kelas_petugas),
            'is_approved'   => true, // Langsung disetujui
            'is_active'     => true, // Langsung aktif
        ]);

        // Reset form & tutup modal
        $this->reset(['nama', 'nta', 'kelas_petugas', 'showModal']);

        session()->flash('success', 'Petugas baru berhasil ditambahkan!');
    }

    // Fungsi Toggle Keaktifan (Yang sudah dibuat sebelumnya)
    public function toggleStatus($id)
    {
        $petugas = PetugasAbsensi::findOrFail($id);
        $petugas->is_active = !$petugas->is_active;
        $petugas->save();
    }

    public function render()
    {
        $now = Carbon::now();

        // 1. Ambil Tanggal Awal & Akhir Minggu Ini
        $startOfWeek = $now->copy()->startOfWeek()->format('Y-m-d');
        $endOfWeek   = $now->copy()->endOfWeek()->format('Y-m-d');

        // 2. Format Teks Label Tanggal
        $currentWeekLabel = "Minggu Ke-" . $now->weekOfMonth . " (" . $now->copy()->startOfWeek()->format('d M') . " - " . $now->copy()->endOfWeek()->format('d M Y') . ")";
        $currentMonthKey  = $now->translatedFormat('F Y');
        $currentYearLabel = $now->year;

        // 3. CARD 1: Total Seluruh Anak / Siswa yang Diabsen
        $totalAbsensiAnak = DB::table('attendances')->count();

        // 4. CARD 2: Rekam Kelas Minggu Ini (Menghitung kombinasi Kelas + Tanggal)
        $rekamMingguIni = DB::table('attendances')
            ->whereBetween(DB::raw('DATE(record_date)'), [$startOfWeek, $endOfWeek])
            ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
            ->value('total') ?? 0;

        // 5. CARD 3: Rekam Kelas Bulan Ini
        $rekamBulanIni = DB::table('attendances')
            ->whereYear('record_date', $now->year)
            ->whereMonth('record_date', $now->month)
            ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
            ->value('total') ?? 0;

        // 6. CARD 4: Rekam Kelas Tahun Ini
        $rekamTahunIni = DB::table('attendances')
            ->whereYear('record_date', $now->year)
            ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
            ->value('total') ?? 0;

        // 7. Ambil Data Petugas
        $petugasList = PetugasAbsensi::latest()->get()->map(function ($p) {
            $countFromAttendances = DB::table('attendances')
                ->where('petugas_nta', trim($p->nta))
                ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
                ->value('total');

            $p->jumlah_rekam = $countFromAttendances > 0 ? $countFromAttendances : ($p->attributes['jumlah_rekam'] ?? 0);
            return $p;
        });

        return view('livewire.admin.daftar-petugas', [
            'petugasList'      => $petugasList,
            'totalAbsensiAnak' => $totalAbsensiAnak,
            'rekamMingguIni'   => $rekamMingguIni,
            'rekamBulanIni'    => $rekamBulanIni,
            'rekamTahunIni'    => $rekamTahunIni,
            'currentWeekLabel' => $currentWeekLabel,
            'currentMonthKey'  => $currentMonthKey,
            'currentYearLabel' => $currentYearLabel,
        ]);
    }
}
