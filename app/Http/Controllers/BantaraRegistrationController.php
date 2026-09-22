<?php

namespace App\Http\Controllers;

use App\Models\BantaraRegistration;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BantaraRegistrationController extends Controller
{
    /**
     * Menampilkan halaman formulir pendaftaran Bantara.
     */
    public function index()
    {
        return view('pages.pendaftaran-bantara'); 
    }

    /**
     * Menyimpan data pendaftaran dari frontend ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari user (menerima 'Laki-laki' / 'Perempuan' serta 'L' / 'P')
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan,L,P',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'motivasi' => 'required|string',
            'whatsapp' => 'required|string|max:20',
            'nomor_orang_tua' => 'required|string|max:20',
            'surat_izin' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        // 2. Simpan berkas surat izin ke folder storage public
        $filePath = null;
        if ($request->hasFile('surat_izin') && $request->file('surat_izin')->isValid()) {
            $filePath = $request->file('surat_izin')->store('pendaftaran-bantara', 'public');
        }

        // Optional: Konversi nilai jika kolom DB Anda hanya menerima 'L' / 'P'
        $jk = $validated['jenis_kelamin'];
        if ($jk === 'Laki-laki') {
            $jk = 'L';
        } elseif ($jk === 'Perempuan') {
            $jk = 'P';
        }

        // 3. Simpan data lengkap ke database
        $registration = BantaraRegistration::create([
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'jenis_kelamin' => $jk, // Menyimpan nilai 'L'/'P' atau 'Laki-laki'/'Perempuan'
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'kecamatan' => $validated['kecamatan'],
            'kabupaten' => $validated['kabupaten'],
            'tempat_tanggal_lahir' => $validated['tempat_tanggal_lahir'],
            'motivasi' => $validated['motivasi'],
            'whatsapp' => $validated['whatsapp'],
            'nomor_orang_tua' => $validated['nomor_orang_tua'],
            'surat_izin_path' => $filePath,
            'status_verifikasi' => 'pending',
        ]);

        Notification::query()->create([
            'title' => 'Pendaftaran Bantara baru',
            'message' => 'Pendaftaran baru dari ' . $registration->nama . ' menunggu verifikasi admin.',
            'type' => 'info',
            'is_read' => false,
            'url' => route('admin.pendaftaran'),
            'data' => [
                'registration_type' => 'bantara',
                'registration_id' => $registration->id,
            ],
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()
            ->route('pendaftaran-bantara')
            ->with('pendaftaran_success', 'Pendaftaran Bantara berhasil dikirim! Panitia akan melakukan verifikasi.');
    }
}