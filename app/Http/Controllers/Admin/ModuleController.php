<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
        return view('admin.modules.gallery', [
            'title' => 'Kelola Galeri',
            'description' => 'Kelola foto dan galeri acara Pramuka.',
            'publicRoute' => route('gallery'),
            'publicLabel' => 'Lihat Halaman Galeri',
        ]);
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
        return view('admin.modules.pembina', [
            'title' => 'Kelola Pembina',
            'description' => 'Kelola data pembina dan penanggung jawab acara.',
        ]);
    }

    public function anggota()
    {
        return view('admin.modules.anggota', [
            'title' => 'Kelola Anggota',
            'description' => 'Lihat dan kelola anggota Pramuka yang terdaftar.',
            'publicRoute' => route('active-board'),
            'publicLabel' => 'Lihat Halaman Anggota',
        ]);
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
