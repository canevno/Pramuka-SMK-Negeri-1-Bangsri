<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DewanAmbalan;
use App\Models\GalleryItem;
use App\Models\Pembina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function news()
    {
        return view('admin.modules.news', [
            'title' => 'Kelola Berita',
            'description' => 'Tambahkan, edit, dan hapus berita yang tampil di website.',
            'publicRoute' => route('news'),
            'publicLabel' => 'Lihat Halaman Berita',
        ]);
    }

    public function gallery()
    {
        $items = GalleryItem::query()
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.modules.gallery', [
            'title' => 'Kelola Galeri',
            'description' => 'Kelola foto dan galeri acara Pramuka.',
            'publicRoute' => route('gallery'),
            'publicLabel' => 'Lihat Halaman Galeri',
            'items' => $items,
            'stats' => [
                'total_album' => $items->count(),
                'total_foto' => $items->count(),
                'featured' => $items->where('is_featured', true)->count(),
                'published' => $items->where('is_published', true)->count(),
            ],
        ]);
    }

    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $imagePath = $validated['image'] ?? 'images/gallery/default.jpg';

        if ($request->hasFile('image')) {
            $storedPath = $request->file('image')->store('gallery', 'public');
            $imagePath = 'storage/' . $storedPath;
        }

        $imagePath = preg_replace('#^/?public/?#', '', $imagePath ?? '');
        $imagePath = str_replace('\\', '/', (string) $imagePath);
        $imagePath = preg_replace('#^/?storage/?#', 'storage/', $imagePath);

        if (str_starts_with($imagePath, 'public/')) {
            $imagePath = preg_replace('#^public/#', '', $imagePath);
        }

        if (str_starts_with($imagePath, '/')) {
            $imagePath = ltrim($imagePath, '/');
        }

        if ($imagePath === '') {
            $imagePath = 'images/gallery/default.jpg';
        }

        $galleryItem = GalleryItem::query()->create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'group' => 'umum',
            'location' => $validated['location'] ?? null,
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'alt_text' => $validated['alt_text'] ?? $validated['title'],
            'published_at' => $validated['published_at'] ?? now()->toDateString(),
            'is_published' => (bool) ($validated['is_published'] ?? true),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
        ]);

        \App\Models\Notification::query()->create([
            'title' => 'Album galeri ditambahkan',
            'message' => 'Album "' . $galleryItem->title . '" berhasil ditambahkan ke galeri publik.',
            'type' => 'success',
            'is_read' => false,
        ]);

        return redirect()->route('admin.gallery')->with('success', 'Album galeri berhasil ditambahkan.');
    }

    public function deleteGallery($id)
    {
        GalleryItem::query()->whereKey($id)->delete();

        return redirect()->route('admin.gallery')->with('success', 'Album galeri berhasil dihapus.');
    }

    public function agenda()
    {
        return view('admin.modules.agenda', [
            'title' => 'Kelola Agenda',
            'description' => 'Atur kegiatan dan jadwal Pramuka.',
            'publicRoute' => route('event'),
            'publicLabel' => 'Lihat Halaman Agenda',
        ]);
    }

    public function pendaftaranLaksana()
    {
        return view('admin.modules.pendaftaran-laksana', [
            'title' => 'Kelola Pendaftaran Laksana',
            'description' => 'Kelola pendaftaran khusus peserta Laksana.',
            'publicRoute' => route('pendaftaran-laksana'),
            'publicLabel' => 'Lihat Halaman Pendaftaran Laksana',
        ]);
    }

    public function pembina()
    {
        $pembinas = Schema::hasTable('pembinas')
            ? Pembina::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : collect();

        return view('admin.modules.pembina', [
            'title' => 'Kelola Pembina',
            'description' => 'Kelola data pembina dan penanggung jawab acara.',
            'publicRoute' => route('pembina'),
            'publicLabel' => 'Lihat Halaman Pembina',
            'pembinas' => $pembinas,
            'stats' => [
                'total' => $pembinas->count(),
                'aktif' => $pembinas->where('is_active', true)->count(),
                'nonaktif' => $pembinas->where('is_active', false)->count(),
                'kontak' => $pembinas->filter(fn ($item) => ! empty($item->phone) || ! empty($item->email))->count(),
            ],
        ]);
    }

    public function storePembina(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'photo_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $photoUrl = $validated['photo_url'] ?? null;

        if ($request->hasFile('photo')) {
            $storedPath = $request->file('photo')->store('pembina', 'public');
            $photoUrl = 'storage/' . $storedPath;
        }

        Pembina::query()->create([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'status' => $validated['status'] ?? 'Aktif',
            'bio' => $validated['bio'] ?? null,
            'photo_url' => $photoUrl,
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.pembina')->with('success', 'Data pembina berhasil ditambahkan.');
    }

    public function togglePembina(Pembina $pembina)
    {
        $pembina->is_active = ! $pembina->is_active;
        $pembina->status = $pembina->is_active ? 'Aktif' : 'Non-Aktif';
        $pembina->save();

        return redirect()->route('admin.pembina')->with('success', 'Status pembina berhasil diperbarui.');
    }

    public function deletePembina(Pembina $pembina)
    {
        $pembina->delete();

        return redirect()->route('admin.pembina')->with('success', 'Data pembina berhasil dihapus.');
    }

    public function dewanAmbalan()
    {
        $members = Schema::hasTable('dewan_ambalans')
            ? DewanAmbalan::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : collect();

        return view('admin.modules.dewan-ambalan', [
            'title' => 'Kelola Dewan Ambalan',
            'description' => 'Kelola data dewan ambalan yang tampil di halaman depan.',
            'publicRoute' => route('dewan-ambalan'),
            'publicLabel' => 'Lihat Halaman Dewan Ambalan',
            'members' => $members,
            'stats' => [
                'total' => $members->count(),
                'aktif' => $members->where('is_active', true)->count(),
                'nonaktif' => $members->where('is_active', false)->count(),
                'kontak' => $members->filter(fn ($item) => ! empty($item->phone) || ! empty($item->email))->count(),
            ],
        ]);
    }

    public function storeDewanAmbalan(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'photo_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $photoUrl = $validated['photo_url'] ?? null;

        if ($request->hasFile('photo')) {
            $storedPath = $request->file('photo')->store('dewan-ambalan', 'public');
            $photoUrl = 'storage/' . $storedPath;
        }

        DewanAmbalan::query()->create([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'status' => $validated['status'] ?? 'Aktif',
            'bio' => $validated['bio'] ?? null,
            'photo_url' => $photoUrl,
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.dewan-ambalan')->with('success', 'Data dewan ambalan berhasil ditambahkan.');
    }

    public function toggleDewanAmbalan(DewanAmbalan $dewanAmbalan)
    {
        $dewanAmbalan->is_active = ! $dewanAmbalan->is_active;
        $dewanAmbalan->status = $dewanAmbalan->is_active ? 'Aktif' : 'Non-Aktif';
        $dewanAmbalan->save();

        return redirect()->route('admin.dewan-ambalan')->with('success', 'Status dewan ambalan berhasil diperbarui.');
    }

    public function deleteDewanAmbalan(DewanAmbalan $dewanAmbalan)
    {
        $dewanAmbalan->delete();

        return redirect()->route('admin.dewan-ambalan')->with('success', 'Data dewan ambalan berhasil dihapus.');
    }

    public function anggota()
    {
        $query = \App\Models\Student::query();

        if (Schema::hasColumn('students', 'sort_order')) {
            $query->orderBy('sort_order');
        }

        if (Schema::hasColumn('students', 'nama')) {
            $query->orderBy('nama');
        }

        $anggota = $query->get();

        return view('admin.modules.anggota', [
            'title' => 'Kelola Anggota Dewan',
            'description' => 'Lihat dan kelola data anggota dewan yang tampil di halaman depan.',
            'publicRoute' => route('anggota-dewan'),
            'publicLabel' => 'Lihat Halaman Anggota Dewan',
            'anggota' => $anggota,
            'stats' => [
                'total' => $anggota->count(),
                'aktif' => $anggota->where('is_active', true)->count(),
                'nonaktif' => $anggota->where('is_active', false)->count(),
                'jabatan' => $anggota->filter(fn ($item) => ! empty($item->jabatan))->count(),
            ],
        ]);
    }

    public function storeAnggota(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_asal' => 'nullable|string|max:50',
            'sangga' => 'nullable|string|max:100',
            'sub_sangga' => 'nullable|string|max:100',
            'ambalan' => 'nullable|in:PA,PI',
            'jabatan' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $photoUrl = 'storage/' . $request->file('photo')->store('anggota', 'public');
        }

        \App\Models\Student::query()->create([
            'nama' => trim($validated['nama']),
            'kelas_asal' => $validated['kelas_asal'] ?? null,
            'sangga' => $validated['sangga'] ?? null,
            'sub_sangga' => $validated['sub_sangga'] ?? null,
            'ambalan' => $validated['ambalan'] ?? null,
            'jabatan' => $validated['jabatan'] ?? null,
            'status' => $validated['status'] ?? 'Aktif',
            'photo_url' => $photoUrl,
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.anggota')->with('success', 'Data anggota dewan berhasil ditambahkan.');
    }

    public function toggleAnggota(\App\Models\Student $student)
    {
        $student->is_active = ! $student->is_active;
        $student->status = $student->is_active ? 'Aktif' : 'Non-Aktif';
        $student->save();

        return redirect()->route('admin.anggota')->with('success', 'Status anggota dewan berhasil diperbarui.');
    }

    public function updateAnggota(Request $request, \App\Models\Student $student)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_asal' => 'nullable|string|max:50',
            'sangga' => 'nullable|string|max:100',
            'sub_sangga' => 'nullable|string|max:100',
            'ambalan' => 'nullable|in:PA,PI',
            'jabatan' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = 'storage/' . $request->file('photo')->store('anggota', 'public');
        }

        $student->fill([
            'nama' => trim($validated['nama']),
            'kelas_asal' => $validated['kelas_asal'] ?? null,
            'sangga' => $validated['sangga'] ?? null,
            'sub_sangga' => $validated['sub_sangga'] ?? null,
            'ambalan' => $validated['ambalan'] ?? null,
            'jabatan' => $validated['jabatan'] ?? null,
            'status' => $validated['status'] ?? ($validated['is_active'] ?? $student->is_active ? 'Aktif' : 'Non-Aktif'),
            'photo_url' => $validated['photo_url'] ?? $student->photo_url,
            'is_active' => (bool) ($validated['is_active'] ?? $student->is_active),
            'sort_order' => (int) ($validated['sort_order'] ?? $student->sort_order ?? 0),
        ]);

        if ($student->is_active && empty($student->status)) {
            $student->status = 'Aktif';
        }

        if (! $student->is_active) {
            $student->status = 'Non-Aktif';
        }

        $student->save();

        return redirect()->route('admin.anggota')->with('success', 'Data anggota dewan berhasil diperbarui.');
    }

    public function deleteAnggota(\App\Models\Student $student)
    {
        $student->delete();

        return redirect()->route('admin.anggota')->with('success', 'Data anggota dewan berhasil dihapus.');
    }

    public function deleteAllAnggota()
    {
        \App\Models\Student::query()->delete();

        return redirect()->route('admin.anggota')->with('success', 'Semua data anggota dewan berhasil dihapus.');
    }

    public function prestasi()
    {
        return view('admin.modules.prestasi', [
            'title' => 'Kelola Prestasi',
            'description' => 'Tambah dan kelola prestasi anggota.',
            'publicRoute' => route('achievement'),
            'publicLabel' => 'Lihat Halaman Prestasi',
        ]);
    }

    public function downloads()
    {
        return view('admin.modules.downloads', [
            'title' => 'Kelola File Download',
            'description' => 'Kelola berkas yang dapat diunduh oleh pengguna.',
        ]);
    }

    public function users()
    {
        return view('admin.modules.users', [
            'title' => 'Pengguna/Admin',
            'description' => 'Kelola akun pengguna dan hak akses admin.',
        ]);
    }

    public function settings()
    {
        return view('admin.modules.settings', [
            'title' => 'Pengaturan Website',
            'description' => 'Atur konfigurasi umum website dan tampilan publik.',
        ]);
    }

    public function comments()
    {
        return view('admin.modules.comments', [
            'title' => 'Kelola Komentar',
            'description' => 'Review dan moderasi komentar pengguna.',
        ]);
    }
}
