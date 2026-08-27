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
            ['label' => 'Total Pendaftar', 'value' => '42', 'caption' => 'Bulan ini'],
            ['label' => 'Disetujui', 'value' => '28', 'caption' => 'Sudah lolos'],
            ['label' => 'Pending', 'value' => '11', 'caption' => 'Menunggu review'],
            ['label' => 'Ditolak', 'value' => '3', 'caption' => 'Perlu koreksi'],
        ],
        'table' => [
            'headers' => ['Nama', 'Golongan', 'Asal', 'Status'],
            'rows' => [
                ['Rafi Hidayat', 'Laksana', 'SMK 1', 'Disetujui'],
                ['Alya Nuraeni', 'Laksana', 'SMA 2', 'Pending'],
                ['Dian Kusuma', 'Laksana', 'SMA 5', 'Ditolak'],
            ],
        ],
        'formFields' => [
            ['label' => 'Nama lengkap', 'placeholder' => 'Masukkan nama lengkap'],
            ['label' => 'Golongan', 'placeholder' => 'Contoh: Laksana'],
            ['label' => 'Asal sekolah', 'placeholder' => 'Masukkan sekolah / gugus'],
            ['label' => 'Status verifikasi', 'type' => 'select', 'options' => ['Pending', 'Disetujui', 'Ditolak']],
            ['label' => 'Catatan admin', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Catatan atau keterangan verifikasi'],
        ],
    ])
@endsection
