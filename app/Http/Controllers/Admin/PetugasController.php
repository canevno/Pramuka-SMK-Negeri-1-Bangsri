<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\PetugasAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $petugasColumns = ['nama', 'nta', 'kelas_petugas', 'is_active'];
        if (Schema::hasColumn('petugas_absensis', 'status')) {
            $petugasColumns[] = 'status';
        }

        $registeredPetugas = PetugasAbsensi::query()
            ->select($petugasColumns)
            ->get()
            ->keyBy('nta');

        $petugas = AttendanceRecord::query()
            ->select('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->selectRaw('MAX(created_at) as last_seen')
            ->selectRaw('COUNT(*) as total_records')
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
                    'last_seen' => $lastSeen,
                    'total_records' => $record->total_records,
                    'status' => $isActive ? 'Aktif' : 'Non-Aktif',
                    'last_seen_text' => $lastSeen->translatedFormat('d F Y H:i'),
                ];
            })
            ->filter()
            ->values();

        $registeredPetugas = PetugasAbsensi::query()->latest()->get();

        return view('admin.petugas', [
            'petugas' => $petugas,
            'registeredPetugas' => $registeredPetugas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:255'],
            'nta' => ['required', 'string', 'max:50', 'unique:petugas_absensis,nta'],
            'kelas_petugas' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:12288'],
        ]);

        $photoUrl = null;

        if ($request->hasFile('photo')) {
            $photoUrl = 'storage/' . $request->file('photo')->store('petugas', 'public');
        }

        $petugasData = [
            'nama' => trim($validated['nama']),
            'nta' => trim($validated['nta']),
            'kelas_petugas' => trim($validated['kelas_petugas']),
            'is_approved' => true,
            'is_active' => true,
            'photo_url' => $photoUrl,
        ];

        if (Schema::hasColumn('petugas_absensis', 'jenis_kelamin')) {
            $petugasData['jenis_kelamin'] = $validated['jenis_kelamin'] ?? 'L';
        }

        if (Schema::hasColumn('petugas_absensis', 'status')) {
            $petugasData['status'] = 'Aktif';
        }

        PetugasAbsensi::query()->create($petugasData);

        return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function toggle($id)
    {
        $petugas = PetugasAbsensi::query()->findOrFail($id);
        $petugas->is_active = ! $petugas->is_active;

        if (Schema::hasColumn('petugas_absensis', 'status')) {
            $petugas->status = $petugas->is_active ? 'Aktif' : 'Non-Aktif';
        }

        $petugas->save();

        return redirect()->route('admin.petugas')->with('success', 'Status petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = PetugasAbsensi::query()->findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil dihapus.');
    }
}
