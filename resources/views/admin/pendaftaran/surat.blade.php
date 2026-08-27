@extends('admin.layouts.app')

@section('title', 'Surat Pendaftaran ' . ($registration->nama ?? ''))

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-lg font-semibold mb-4">Surat Pendaftaran {{ $registration->nama }}</h1>
        <div class="border rounded-lg overflow-hidden">
            <iframe src="{{ $fileUrl }}" class="w-full h-[80vh]" frameborder="0"></iframe>
        </div>
    </div>
</div>
@endsection
