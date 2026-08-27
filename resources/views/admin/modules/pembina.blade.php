@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
    @include('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Pembina Aktif', 'value' => '12', 'caption' => 'Menangani program'],
            ['label' => 'Terjadwal', 'value' => '5', 'caption' => 'Kegiatan bulan ini'],
            ['label' => 'Koordinator', 'value' => '3', 'caption' => 'Tim inti'],
            ['label' => 'Kontak', 'value' => '24', 'caption' => 'Data valid'],
        ],
        'table' => [
            'headers' => ['Nama', 'Jabatan', 'Kontak', 'Status'],
            'rows' => [
                ['Bapak Surya', 'Pembina Gudep', '0812xxxx', 'Aktif'],
                ['Ibu Wati', 'Koordinator', '0888xxxx', 'Aktif'],
                ['Bapak Andi', 'Pembina Lapangan', '0811xxxx', 'Tidak aktif'],
            ],
        ],
        'formFields' => [
            ['label' => 'Nama pembina', 'placeholder' => 'Masukkan nama lengkap'],
            ['label' => 'Jabatan', 'placeholder' => 'Pembina / Koordinator / Mentor'],
            ['label' => 'Kontak', 'placeholder' => 'Nomor telepon atau email'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Aktif', 'Tidak aktif']],
            ['label' => 'Catatan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Deskripsi tugas dan pengalaman pembina'],
        ],
    ])
@endsection
