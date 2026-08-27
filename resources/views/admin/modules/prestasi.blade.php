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
            ['label' => 'Total Prestasi', 'value' => '31', 'caption' => 'Pencapaian tercatat'],
            ['label' => 'Nasional', 'value' => '6', 'caption' => 'Prestasi tingkat tinggi'],
            ['label' => 'Daerah', 'value' => '12', 'caption' => 'Lintas wilayah'],
            ['label' => 'Sekolah', 'value' => '13', 'caption' => 'Internal gugus'],
        ],
        'table' => [
            'headers' => ['Prestasi', 'Kategori', 'Tahun', 'Peserta'],
            'rows' => [
                ['Juara 1 PBB', 'Daerah', '2024', 'Regu Mawar'],
                ['Lomba Cerdas Cermat', 'Sekolah', '2024', 'Kelompok 12'],
                ['Kegiatan Kader', 'Nasional', '2023', 'Ari & Tim'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul prestasi', 'placeholder' => 'Masukkan judul prestasi'],
            ['label' => 'Kategori', 'placeholder' => 'Sekolah / Daerah / Nasional'],
            ['label' => 'Tahun', 'type' => 'number', 'placeholder' => '2025'],
            ['label' => 'Peserta', 'placeholder' => 'Nama peserta atau regu'],
            ['label' => 'Deskripsi', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tuliskan deskripsi dan pencapaian'],
        ],
    ])
@endsection
