<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\DewanAmbalan;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Mitra;
use App\Models\Setting;
use App\Models\Pembina;
use App\Models\Post;
use App\Models\TimelineEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function publicNewsPage()
    {
        $query = Post::query()->where('is_published', true);

        $posts = $query
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        if (Schema::hasColumn('posts', 'sort_order')) {
            $posts->orderBy('sort_order');
        }

        $posts = $posts->get();

        $newsItems = $posts->map(function (Post $post) {
            return [
                'slug' => $post->slug,
                'category' => $post->type ?: 'Berita',
                'title' => $post->title,
                'date' => $post->published_at?->translatedFormat('d F Y') ?? 'Tanggal belum diatur',
                'description' => $post->excerpt ?: Str::limit(strip_tags($post->content ?? ''), 120),
                'image' => $this->resolvePublicImageUrl($post->image_path),
                'alt' => $post->title,
            ];
        })->all();

        if (empty($newsItems)) {
            $newsItems = [
                ['slug' => 'pramuka-peduli-lingkungan-pantai', 'category' => 'Sosial', 'title' => 'Pramuka Peduli Lingkungan Pantai', 'date' => 'Januari 8, 2024', 'description' => 'Aksi membersihkan sampah plastik pantai Bangsri sebagai bentuk pengabdian.', 'image' => 'images/hero/imagehero1.png', 'alt' => 'Pramuka Peduli Lingkungan Pantai'],
                ['slug' => 'kemping-karakter-di-hutan-kareta', 'category' => 'Camping', 'title' => 'Kemping Karakter di Hutan Kareta', 'date' => 'Januari 8, 2024', 'description' => 'Perkemahan tiga hari memperkuat kemandirian, kerja tim, dan ketahanan fisik.', 'image' => 'images/hero/imagehero.png', 'alt' => 'Kemping Karakter di Hutan Kareta'],
                ['slug' => 'gelar-seni-budaya-nusantara', 'category' => 'Budaya', 'title' => 'Gelar Seni Budaya Nusantara', 'date' => 'Januari 8, 2024', 'description' => 'Pertunjukan seni daerah memadukan tradisi dan kreativitas Pramuka.', 'image' => 'images/logokegiatan1.png', 'alt' => 'Gelar Seni Budaya Nusantara'],
                ['slug' => 'latihan-navigasi-darat-menantang', 'category' => 'Skills', 'title' => 'Latihan Navigasi Darat Menantang', 'date' => 'Januari 8, 2024', 'description' => 'Menguji orientasi lapangan dengan kompas dan peta di medan nyata.', 'image' => 'images/logos/smklogo.png', 'alt' => 'Latihan Navigasi Darat Menantang'],
                ['slug' => 'pertemuan-alumni-dan-prestasi', 'category' => 'Event', 'title' => 'Pertemuan Alumni dan Prestasi', 'date' => 'Januari 8, 2024', 'description' => 'Forum alumni merayakan capaian anggota dan memperkuat koneksi Pramuka.', 'image' => 'images/hero/imagehero.png', 'alt' => 'Pertemuan Alumni dan Prestasi'],
            ];
        }

        return view('pages.news', compact('newsItems'));
    }

    public function showNewsDetail(string $slug)
    {
        $post = Post::query()
            ->where('is_published', true)
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $relatedPosts = Post::query()
            ->where('is_published', true)
            ->whereKeyNot($post->id)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $article = [
            'category' => $post->type ?: 'Berita',
            'title' => $post->title,
            'date' => $post->published_at?->translatedFormat('d F Y') ?? 'Tanggal belum diatur',
            'description' => $post->excerpt ?: Str::limit(strip_tags($post->content ?? ''), 140),
            'content' => $post->content ?? $post->excerpt ?? 'Konten berita belum tersedia.',
            'image' => $this->resolvePublicImageUrl($post->image_path),
            'alt' => $post->title,
            'slug' => $post->slug,
        ];

        $related = $relatedPosts->map(function (Post $item) {
            return [
                'slug' => $item->slug,
                'category' => $item->type ?: 'Berita',
                'title' => $item->title,
                'date' => $item->published_at?->translatedFormat('d F Y') ?? 'Tanggal belum diatur',
                'description' => $item->excerpt ?: Str::limit(strip_tags($item->content ?? ''), 100),
                'image' => $this->resolvePublicImageUrl($item->image_path),
                'alt' => $item->title,
            ];
        })->all();

        return view('pages.news-detail', compact('article', 'related'));
    }

    public function news()
    {
        $query = Post::query();

        $posts = $query
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        if (Schema::hasColumn('posts', 'sort_order')) {
            $posts->orderBy('sort_order');
        }

        $posts = $posts->get();

        return view('admin.modules.news', [
            'title' => 'Kelola Berita',
            'description' => 'Tambahkan, edit, dan hapus berita yang tampil di website.',
            'publicRoute' => route('news'),
            'publicLabel' => 'Lihat Halaman Berita',
            'posts' => $posts,
            'stats' => [
                ['label' => 'Total Berita', 'value' => (string) $posts->count(), 'caption' => 'Artikel terdaftar'],
                ['label' => 'Draft', 'value' => (string) $posts->where('is_published', false)->count(), 'caption' => 'Belum diterbitkan'],
                ['label' => 'Terbit', 'value' => (string) $posts->where('is_published', true)->count(), 'caption' => 'Sudah publik'],
                ['label' => 'Terbaru', 'value' => $posts->first()?->published_at?->translatedFormat('d M Y') ?? '-', 'caption' => 'Update terakhir'],
            ],
        ]);
    }

    public function hero()
    {
        $settings = [];

        if (Schema::hasTable('settings')) {
            $settings = Setting::query()->pluck('value', 'key')->all();
        }

        return view('admin.modules.hero', [
            'title' => 'Kelola Hero Frontend',
            'description' => 'Upload 3 gambar utama yang akan tampil di homepage. Cukup upload gambar dan hapus bila diperlukan.',
            'publicRoute' => route('home'),
            'publicLabel' => 'Lihat Halaman Depan',
            'settings' => $settings,
        ]);
    }

    public function storeHero(Request $request)
    {
        $request->validate([
            'hero_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image_3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ([1, 2, 3] as $slot) {
            $key = 'hero_image_' . $slot;

            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                Setting::setValue($key, $path);
                continue;
            }

            if ($request->boolean('remove_' . $key)) {
                Setting::query()->where('key', $key)->delete();
            }
        }

        return redirect()->route('admin.hero')->with('success', 'Gambar hero berhasil disimpan.');
    }

    public function updateHero(Request $request, HeroSlide $heroSlide)
    {
        return redirect()->route('admin.hero')->with('success', 'Pengelolaan hero hanya menggunakan 3 gambar utama.');
    }

    public function toggleHero(HeroSlide $heroSlide)
    {
        return redirect()->route('admin.hero')->with('success', 'Pengelolaan hero hanya menggunakan 3 gambar utama.');
    }

    public function deleteHero(HeroSlide $heroSlide)
    {
        return redirect()->route('admin.hero')->with('success', 'Pengelolaan hero hanya menggunakan 3 gambar utama.');
    }

    public function storeNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $imagePath = $request->hasFile('image') && $request->file('image')->isValid()
            ? $this->resolvePostImagePath($request)
            : null;

        $slug = Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 1;

        while (Post::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data = [
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'type' => $validated['type'],
            'image_path' => $imagePath,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? now(),
            'is_published' => $request->boolean('is_published', true),
        ];

        if (Schema::hasColumn('posts', 'sort_order')) {
            $data['sort_order'] = $validated['sort_order'] ?? Post::query()->max('sort_order') + 1;
        }

        $post = Post::query()->create($data);

        return redirect()->route('admin.news')->with('success', 'Berita "' . $post->title . '" berhasil ditambahkan.');
    }

    public function updateNews(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $slug = Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 1;

        while (Post::query()->where('slug', $slug)->whereKeyNot($post->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $newImagePath = $request->hasFile('image') && $request->file('image')->isValid()
            ? $this->resolvePostImagePath($request)
            : ($post->image_path ?? null);

        $data = [
            'title' => $validated['title'],
            'slug' => $slug,
            'type' => $validated['type'],
            'image_path' => $newImagePath,
            'excerpt' => $validated['excerpt'] ?? $post->excerpt,
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? $post->published_at,
            'is_published' => $request->boolean('is_published', $post->is_published),
        ];

        if (Schema::hasColumn('posts', 'sort_order')) {
            $data['sort_order'] = $validated['sort_order'] ?? $post->sort_order ?? 0;
        }

        $post->update($data);

        return redirect()->route('admin.news')->with('success', 'Berita "' . $post->title . '" berhasil diperbarui.');
    }

    public function duplicateNews(Post $post)
    {
        $duplicate = $post->replicate();
        $duplicate->title = $post->title . ' (Salinan)';
        $duplicate->slug = $this->generateUniqueSlug($duplicate->title, $post->id);
        $duplicate->sort_order = $post->sort_order ?? 0;
        $duplicate->save();

        return redirect()->route('admin.news')->with('success', 'Berita berhasil diduplikasi.');
    }

    public function deleteNews(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.news')->with('success', 'Berita berhasil dihapus.');
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $base = $slug;
        $counter = 1;

        while (Post::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected function resolvePostImagePath(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $path = $request->file('image')->store('news', 'public');

        return $path;
    }

    protected function resolvePublicImageUrl(?string $imagePath): string
    {
        if (empty($imagePath)) {
            return asset('images/hero/imagehero1.png');
        }

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        if (str_starts_with($imagePath, 'storage/')) {
            return asset($imagePath);
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        return asset('storage/' . ltrim($imagePath, '/'));
    }

    protected function resolveHeroImagePath(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return $request->input('image_url') ?: null;
        }

        $path = $request->file('image')->store('hero', 'public');

        return 'storage/' . $path;
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

        $imagePath = $this->resolveGalleryImagePath($request, $validated['image'] ?? null);

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

    public function updateGallery(Request $request, $id)
    {
        $galleryItem = GalleryItem::query()->findOrFail($id);

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

        $imagePath = $this->resolveGalleryImagePath($request, $validated['image'] ?? $galleryItem->image);

        $galleryItem->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'group' => 'umum',
            'location' => $validated['location'] ?? null,
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'alt_text' => $validated['alt_text'] ?? $validated['title'],
            'published_at' => $validated['published_at'] ?? $galleryItem->published_at ?? now()->toDateString(),
            'is_published' => (bool) ($validated['is_published'] ?? $galleryItem->is_published),
            'is_featured' => (bool) ($validated['is_featured'] ?? $galleryItem->is_featured),
        ]);

        return redirect()->route('admin.gallery')->with('success', 'Album galeri berhasil diperbarui.');
    }

    public function duplicateGallery($id)
    {
        $galleryItem = GalleryItem::query()->findOrFail($id);

        $duplicateTitle = preg_replace('/\s*\(Salinan\)$/i', '', $galleryItem->title ?? '') . ' (Salinan)';

        $duplicate = $galleryItem->replicate();
        $duplicate->title = $duplicateTitle;
        $duplicate->is_featured = false;
        $duplicate->save();

        return redirect()->route('admin.gallery')->with('success', 'Album galeri berhasil diduplikasi.');
    }

    public function deleteGallery($id)
    {
        GalleryItem::query()->whereKey($id)->delete();

        return redirect()->route('admin.gallery')->with('success', 'Album galeri berhasil dihapus.');
    }

    protected function resolveGalleryImagePath(Request $request, ?string $imageValue = null): string
    {
        $imagePath = $imageValue ?? 'images/gallery/default.jpg';

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

        return $imagePath;
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

    public function timeline()
    {
        $events = Schema::hasTable('timeline_events')
            ? TimelineEvent::query()
                ->orderBy('date')
                ->orderBy('sort_order')
                ->get()
            : collect();

        return view('admin.modules.timeline', [
            'title' => 'Kelola Timeline Kegiatan',
            'description' => 'Kelola jadwal dan kegiatan yang tampil di halaman depan.',
            'publicRoute' => route('event'),
            'publicLabel' => 'Lihat Halaman Timeline',
            'events' => $events,
            'stats' => [
                'total' => $events->count(),
                'upcoming' => $events->where('status', 'upcoming')->count(),
                'active' => $events->where('is_active', true)->count(),
                'completed' => $events->where('status', 'completed')->count(),
            ],
        ]);
    }

    public function storeTimeline(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
            'guide_url' => 'nullable|url|max:255',
            'theme' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:upcoming,ongoing,completed',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('timeline', 'public');
        }

        $payload = [
            'title' => trim($validated['title']),
            'date' => $validated['date'],
            'time' => $validated['time'] ?? null,
            'location' => trim($validated['location']),
            'guide_url' => $validated['guide_url'] ?? null,
            'theme' => $validated['theme'] ?? null,
            'logo_path' => $logoPath,
            'status' => $validated['status'] ?? 'upcoming',
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];

        if (Schema::hasColumn('timeline_events', 'description')) {
            $payload['description'] = $validated['description'] ?? null;
        }

        TimelineEvent::query()->create($payload);

        return redirect()->route('admin.timeline')->with('success', 'Timeline kegiatan berhasil ditambahkan.');
    }

    public function updateTimeline(Request $request, TimelineEvent $timelineEvent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
            'guide_url' => 'nullable|url|max:255',
            'theme' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:upcoming,ongoing,completed',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $logoPath = $timelineEvent->logo_path;
        if ($request->hasFile('logo')) {
            if ($timelineEvent->logo_path && Storage::disk('public')->exists($timelineEvent->logo_path)) {
                Storage::disk('public')->delete($timelineEvent->logo_path);
            }

            $logoPath = $request->file('logo')->store('timeline', 'public');
        }

        $payload = [
            'title' => trim($validated['title']),
            'date' => $validated['date'],
            'time' => $validated['time'] ?? $timelineEvent->time,
            'location' => trim($validated['location']),
            'guide_url' => $validated['guide_url'] ?? $timelineEvent->guide_url,
            'theme' => $validated['theme'] ?? $timelineEvent->theme,
            'logo_path' => $logoPath,
            'status' => $validated['status'] ?? $timelineEvent->status,
            'is_active' => (bool) ($validated['is_active'] ?? $timelineEvent->is_active),
            'sort_order' => (int) ($validated['sort_order'] ?? $timelineEvent->sort_order ?? 0),
        ];

        if (Schema::hasColumn('timeline_events', 'description')) {
            $payload['description'] = $validated['description'] ?? $timelineEvent->description;
        }

        $timelineEvent->fill($payload);

        $timelineEvent->save();

        return redirect()->route('admin.timeline')->with('success', 'Timeline kegiatan berhasil diperbarui.');
    }

    public function toggleTimeline(TimelineEvent $timelineEvent)
    {
        $timelineEvent->is_active = ! $timelineEvent->is_active;
        $timelineEvent->save();

        return redirect()->route('admin.timeline')->with('success', 'Status timeline kegiatan berhasil diperbarui.');
    }

    public function deleteTimeline(TimelineEvent $timelineEvent)
    {
        $timelineEvent->delete();

        return redirect()->route('admin.timeline')->with('success', 'Timeline kegiatan berhasil dihapus.');
    }

    public function showTimelineEvent($id)
    {
        $event = Schema::hasTable('timeline_events') ? TimelineEvent::query()->findOrFail($id) : abort(404);

        return view('pages.event-detail', compact('event'));
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

    public function updatePembina(Request $request, Pembina $pembina)
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

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = 'storage/' . $request->file('photo')->store('pembina', 'public');
        }

        $pembina->fill([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'phone' => $validated['phone'] ?? $pembina->phone,
            'email' => $validated['email'] ?? $pembina->email,
            'status' => $validated['status'] ?? ($validated['is_active'] ?? $pembina->is_active ? 'Aktif' : 'Non-Aktif'),
            'bio' => $validated['bio'] ?? $pembina->bio,
            'photo_url' => $validated['photo_url'] ?? $pembina->photo_url,
            'is_active' => (bool) ($validated['is_active'] ?? $pembina->is_active),
            'sort_order' => (int) ($validated['sort_order'] ?? $pembina->sort_order ?? 0),
        ]);

        if ($pembina->is_active && empty($pembina->status)) {
            $pembina->status = 'Aktif';
        }

        if (! $pembina->is_active) {
            $pembina->status = 'Non-Aktif';
        }

        $pembina->save();

        return redirect()->route('admin.pembina')->with('success', 'Data pembina berhasil diperbarui.');
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

    public function mitra()
    {
        $partners = Schema::hasTable('mitras')
            ? Mitra::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : collect();

        return view('admin.modules.mitra', [
            'title' => 'Kelola Mitra',
            'description' => 'Kelola data mitra yang tampil di halaman depan.',
            'publicRoute' => route('mitra'),
            'publicLabel' => 'Lihat Halaman Mitra',
            'partners' => $partners,
            'stats' => [
                'total' => $partners->count(),
                'aktif' => $partners->where('is_active', true)->count(),
                'nonaktif' => $partners->where('is_active', false)->count(),
                'kontak' => $partners->filter(fn ($item) => ! empty($item->phone) || ! empty($item->email))->count(),
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

    public function updateDewanAmbalan(Request $request, DewanAmbalan $dewanAmbalan)
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

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = 'storage/' . $request->file('photo')->store('dewan-ambalan', 'public');
        }

        $dewanAmbalan->fill([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'phone' => $validated['phone'] ?? $dewanAmbalan->phone,
            'email' => $validated['email'] ?? $dewanAmbalan->email,
            'status' => $validated['status'] ?? ($validated['is_active'] ?? $dewanAmbalan->is_active ? 'Aktif' : 'Non-Aktif'),
            'bio' => $validated['bio'] ?? $dewanAmbalan->bio,
            'photo_url' => $validated['photo_url'] ?? $dewanAmbalan->photo_url,
            'is_active' => (bool) ($validated['is_active'] ?? $dewanAmbalan->is_active),
            'sort_order' => (int) ($validated['sort_order'] ?? $dewanAmbalan->sort_order ?? 0),
        ]);

        if ($dewanAmbalan->is_active && empty($dewanAmbalan->status)) {
            $dewanAmbalan->status = 'Aktif';
        }

        if (! $dewanAmbalan->is_active) {
            $dewanAmbalan->status = 'Non-Aktif';
        }

        $dewanAmbalan->save();

        return redirect()->route('admin.dewan-ambalan')->with('success', 'Data dewan ambalan berhasil diperbarui.');
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

    public function storeMitra(Request $request)
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
            $storedPath = $request->file('photo')->store('mitra', 'public');
            $photoUrl = 'storage/' . $storedPath;
        }

        Mitra::query()->create([
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

        return redirect()->route('admin.mitra')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function updateMitra(Request $request, Mitra $mitra)
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

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = 'storage/' . $request->file('photo')->store('mitra', 'public');
        }

        $mitra->fill([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'phone' => $validated['phone'] ?? $mitra->phone,
            'email' => $validated['email'] ?? $mitra->email,
            'status' => $validated['status'] ?? ($validated['is_active'] ?? $mitra->is_active ? 'Aktif' : 'Non-Aktif'),
            'bio' => $validated['bio'] ?? $mitra->bio,
            'photo_url' => $validated['photo_url'] ?? $mitra->photo_url,
            'is_active' => (bool) ($validated['is_active'] ?? $mitra->is_active),
            'sort_order' => (int) ($validated['sort_order'] ?? $mitra->sort_order ?? 0),
        ]);

        if ($mitra->is_active && empty($mitra->status)) {
            $mitra->status = 'Aktif';
        }

        if (! $mitra->is_active) {
            $mitra->status = 'Non-Aktif';
        }

        $mitra->save();

        return redirect()->route('admin.mitra')->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function toggleMitra(Mitra $mitra)
    {
        $mitra->is_active = ! $mitra->is_active;
        $mitra->status = $mitra->is_active ? 'Aktif' : 'Non-Aktif';
        $mitra->save();

        return redirect()->route('admin.mitra')->with('success', 'Status mitra berhasil diperbarui.');
    }

    public function deleteMitra(Mitra $mitra)
    {
        $mitra->delete();

        return redirect()->route('admin.mitra')->with('success', 'Data mitra berhasil dihapus.');
    }

    public function alumni()
    {
        $members = Schema::hasTable('alumni')
            ? Alumni::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : collect();

        return view('admin.modules.alumni', [
            'title' => 'Kelola Alumni',
            'description' => 'Kelola data alumni yang tampil di halaman depan.',
            'publicRoute' => route('alumni'),
            'publicLabel' => 'Lihat Halaman Alumni',
            'members' => $members,
            'stats' => [
                'total' => $members->count(),
                'aktif' => $members->where('is_active', true)->count(),
                'nonaktif' => $members->where('is_active', false)->count(),
                'jabatan' => $members->filter(fn ($item) => ! empty($item->jabatan))->count(),
            ],
        ]);
    }

    public function storeAlumni(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'status' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'photo_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $photoUrl = $validated['photo_url'] ?? null;

        if ($request->hasFile('photo')) {
            $storedPath = $request->file('photo')->store('alumni', 'public');
            $photoUrl = 'storage/' . $storedPath;
        }

        Alumni::query()->create([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'status' => $validated['status'] ?? 'Aktif',
            'bio' => $validated['bio'] ?? null,
            'photo_url' => $photoUrl,
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil ditambahkan.');
    }

    public function updateAlumni(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'status' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'photo_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = 'storage/' . $request->file('photo')->store('alumni', 'public');
        }

        $alumni->fill([
            'name' => trim($validated['name']),
            'jabatan' => trim($validated['jabatan']),
            'status' => $validated['status'] ?? ($validated['is_active'] ?? $alumni->is_active ? 'Aktif' : 'Non-Aktif'),
            'bio' => $validated['bio'] ?? $alumni->bio,
            'photo_url' => $validated['photo_url'] ?? $alumni->photo_url,
            'is_active' => (bool) ($validated['is_active'] ?? $alumni->is_active),
            'sort_order' => (int) ($validated['sort_order'] ?? $alumni->sort_order ?? 0),
        ]);

        if ($alumni->is_active && empty($alumni->status)) {
            $alumni->status = 'Aktif';
        }

        if (! $alumni->is_active) {
            $alumni->status = 'Non-Aktif';
        }

        $alumni->save();

        return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil diperbarui.');
    }

    public function toggleAlumni(Alumni $alumni)
    {
        $alumni->is_active = ! $alumni->is_active;
        $alumni->status = $alumni->is_active ? 'Aktif' : 'Non-Aktif';
        $alumni->save();

        return redirect()->route('admin.alumni')->with('success', 'Status alumni berhasil diperbarui.');
    }

    public function deleteAlumni(Alumni $alumni)
    {
        $alumni->delete();

        return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil dihapus.');
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
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,heic,heif|max:12288',
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
            'bio' => $validated['bio'] ?? null,
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
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,heic,heif|max:12288',
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
            'bio' => $validated['bio'] ?? $student->bio,
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
