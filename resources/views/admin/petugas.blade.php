@extends('admin.layouts.app')
@section('title', 'Daftar Petugas')
@section('page-heading', 'Daftar Petugas')
@section('page-description', 'Melihat nama petugas, NTA, kelas, dan keaktifan terakhir berdasarkan absensi.')

@section('content')
<div class="space-y-6">
    @livewire('admin.daftar-petugas')
</div>
@endsection