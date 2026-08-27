@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
    @include('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'publicRoute' => $publicRoute ?? null,
        'publicLabel' => $publicLabel ?? null,
        'stats' => [
            ['label' => 'Total Berita', 'value' => '24', 'caption' => 'Artikel aktif'],
            ['label' => 'Draft', 'value' => '6', 'caption' => 'Belum diterbitkan'],
            ['label' => 'Terbit', 'value' => '18', 'caption' => 'Sudah publik'],
            ['label' => 'Kunjungan', 'value' => '3.2k', 'caption' => 'Bulan ini'],
        ],
        'table' => [
            'headers' => ['Judul', 'Kategori', 'Status', 'Tanggal'],
            'rows' => [
                ['Pramuka Peduli Lingkungan', 'Sosial', 'Terbit', '08 Jan 2024'],
                ['Latihan Navigasi Darat', 'Skills', 'Draft', '14 Jan 2024'],
                ['Pelatihan Dasar Bantara', 'Training', 'Terbit', '21 Jan 2024'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul berita', 'placeholder' => 'Masukkan judul berita'],
            ['label' => 'Kategori', 'placeholder' => 'Sosial / Akademik / Event'],
            ['label' => 'Tanggal publikasi', 'type' => 'date'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Draft', 'Terbit', 'Arsip']],
            ['label' => 'Ringkasan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tuliskan ringkasan berita'],
        ],
    ])
@endsection
