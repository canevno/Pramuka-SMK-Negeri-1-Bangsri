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
            ['label' => 'Agenda Bulan Ini', 'value' => '8', 'caption' => 'Kegiatan terjadwal'],
            ['label' => 'Belum Mulai', 'value' => '3', 'caption' => 'Jadwal menunggu'],
            ['label' => 'Sedang Berjalan', 'value' => '2', 'caption' => 'Aktif hari ini'],
            ['label' => 'Selesai', 'value' => '11', 'caption' => 'Telah dilaksanakan'],
        ],
        'table' => [
            'headers' => ['Judul', 'Tanggal', 'Lokasi', 'Status'],
            'rows' => [
                ['Pelantikan Bantara', '12 Jan 2025', 'Lapangan Sekolah', 'Akan Datang'],
                ['Latihan PBB', '18 Jan 2025', 'Halaman Gudep', 'Aktif'],
                ['Camp Out', '25 Jan 2025', 'Hutan Kareta', 'Akan Datang'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul kegiatan', 'placeholder' => 'Masukkan judul acara'],
            ['label' => 'Lokasi', 'placeholder' => 'Masukkan lokasi'],
            ['label' => 'Tanggal', 'type' => 'date'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Akan Datang', 'Aktif', 'Selesai']],
            ['label' => 'Deskripsi kegiatan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tuliskan deskripsi dan tujuan kegiatan'],
        ],
    ])
@endsection
