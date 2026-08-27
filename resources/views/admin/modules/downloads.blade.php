@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
    @include('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Total File', 'value' => '17', 'caption' => 'Dokumen tersedia'],
            ['label' => 'PDF', 'value' => '9', 'caption' => 'Berkas dokumen'],
            ['label' => 'Gambar', 'value' => '4', 'caption' => 'Poster dan banner'],
            ['label' => 'Format Lain', 'value' => '4', 'caption' => 'Dokumen tambahan'],
        ],
        'table' => [
            'headers' => ['Judul', 'Jenis', 'Ukuran', 'Tanggal'],
            'rows' => [
                ['Panduan Bantara', 'PDF', '1.2 MB', '12 Jan 2025'],
                ['Poster Kegiatan', 'Image', '640 KB', '18 Jan 2025'],
                ['Formulir Registrasi', 'DOCX', '230 KB', '22 Jan 2025'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul berkas', 'placeholder' => 'Masukkan judul file'],
            ['label' => 'Kategori', 'placeholder' => 'Dokumen / Poster / Formulir'],
            ['label' => 'Tanggal publikasi', 'type' => 'date'],
            ['label' => 'File upload', 'type' => 'file'],
            ['label' => 'Deskripsi', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Keterangan singkat tentang file'],
        ],
    ])
@endsection
