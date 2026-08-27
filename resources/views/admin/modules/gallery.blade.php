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
            ['label' => 'Total Album', 'value' => '18', 'caption' => 'Koleksi foto'],
            ['label' => 'Foto', 'value' => '214', 'caption' => 'Dokumen terupload'],
            ['label' => 'Acara', 'value' => '7', 'caption' => 'Event aktif'],
            ['label' => 'Publik', 'value' => '91%', 'caption' => 'Sudah dipublikasikan'],
        ],
        'table' => [
            'headers' => ['Judul Album', 'Kategori', 'Foto', 'Tanggal'],
            'rows' => [
                ['Pelantikan Bantara', 'Kegiatan', '32', '12 Nov 2024'],
                ['Lomba Pramuka', 'Acara', '28', '18 Nov 2024'],
                ['Latihan Camping', 'Pelatihan', '41', '30 Nov 2024'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul album', 'placeholder' => 'Masukkan judul album'],
            ['label' => 'Kategori', 'placeholder' => 'Kegiatan / Pelatihan / Event'],
            ['label' => 'Tanggal', 'type' => 'date'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Publik', 'Draft']],
            ['label' => 'Deskripsi', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tuliskan deskripsi album'],
        ],
    ])
@endsection
