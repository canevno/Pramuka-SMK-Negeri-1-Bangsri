<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PetugasAbsensi;

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
        return view('livewire.admin.daftar-petugas', [
            'petugasList' => PetugasAbsensi::latest()->get()
        ]);
    }
}
