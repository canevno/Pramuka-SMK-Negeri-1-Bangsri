@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
    @include('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Status Situs', 'value' => 'Online', 'caption' => 'Website aktif'],
            ['label' => 'Logo', 'value' => '1', 'caption' => 'Brand terpasang'],
            ['label' => 'Badan', 'value' => '2', 'caption' => 'Tema aktif'],
            ['label' => 'Kontak', 'value' => '4', 'caption' => 'Poin informasi'],
        ],
        'table' => [
            'headers' => ['Pengaturan', 'Nilai Saat Ini', 'Status'],
            'rows' => [
                ['Judul Website', 'Scoutmind', 'Aktif'],
                ['Deskripsi', 'Pramuka dan kegiatan komunitas', 'Aktif'],
                ['Kontak Admin', '+62 812-3456-7890', 'Aktif'],
                ['Tema', 'Light / Dark', 'Aktif'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul website', 'placeholder' => 'Masukkan judul website'],
            ['label' => 'Deskripsi singkat', 'placeholder' => 'Deskripsi singkat organisasi'],
            ['label' => 'Kontak admin', 'placeholder' => 'Nomor telepon atau email'],
            ['label' => 'Tema', 'type' => 'select', 'options' => ['Light', 'Dark', 'Sistem default']],
            ['label' => 'Logo situs', 'type' => 'file'],
            ['label' => 'Catatan pengaturan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Catatan untuk info admin'],
        ],
    ])
@endsection
