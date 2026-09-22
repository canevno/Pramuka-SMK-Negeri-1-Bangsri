<?php

namespace App\Http\Controllers;

use App\Models\LaksanaRegistration;
use App\Models\Notification;
use Illuminate\Http\Request;

class LaksanaRegistrationController extends Controller
{
    public function index()
    {
        return view('pages.pendaftaran-laksana');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nta' => 'required|string|max:100',
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

        $filePath = null;
        if ($request->hasFile('surat_izin') && $request->file('surat_izin')->isValid()) {
            $filePath = $request->file('surat_izin')->store('pendaftaran-laksana', 'public');
        }

        $jk = $validated['jenis_kelamin'];
        if ($jk === 'Laki-laki') {
            $jk = 'L';
        } elseif ($jk === 'Perempuan') {
            $jk = 'P';
        }

        $registration = LaksanaRegistration::create([
            'nama' => $validated['nama'],
            'nta' => $validated['nta'],
            'kelas' => $validated['kelas'],
            'jenis_kelamin' => $jk,
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
            'title' => 'Pendaftaran Laksana baru',
            'message' => 'Pendaftaran baru dari ' . $registration->nama . ' menunggu verifikasi admin.',
            'type' => 'info',
            'is_read' => false,
            'url' => route('admin.pendaftaran-laksana'),
            'data' => [
                'registration_type' => 'laksana',
                'registration_id' => $registration->id,
            ],
        ]);

        return redirect()
            ->route('pendaftaran-laksana')
            ->with('pendaftaran_success', 'Pendaftaran Laksana berhasil dikirim! Panitia akan melakukan verifikasi.');
    }
}
