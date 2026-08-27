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
            ['label' => 'Total Anggota', 'value' => '156', 'caption' => 'Aktif saat ini'],
            ['label' => 'Bantara', 'value' => '52', 'caption' => 'Kelompok aktif'],
            ['label' => 'Penegak', 'value' => '64', 'caption' => 'Tingkat menengah'],
            ['label' => 'Aktif 30 Hari', 'value' => '118', 'caption' => 'Mengikuti kegiatan'],
        ],
        'table' => [
            'headers' => ['Nama', 'Golongan', 'Kelas', 'Status'],
            'rows' => [
                ['Rizki Ardi', 'Bantara', 'XI', 'Aktif'],
                ['Nafa Anjani', 'Penegak', 'XII', 'Aktif'],
                ['Andi Putra', 'Bantara', 'X', 'Nonaktif'],
            ],
        ],
        'formFields' => [
            ['label' => 'Nama lengkap', 'placeholder' => 'Masukkan nama anggota'],
            ['label' => 'Golongan', 'placeholder' => 'Siaga / Bantara / Penegak'],
            ['label' => 'Kelas', 'placeholder' => 'Contoh: XI'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Aktif', 'Nonaktif', 'Baru']],
            ['label' => 'Catatan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Catatan keaktifan atau kebutuhan khusus'],
        ],
    ])
@endsection
