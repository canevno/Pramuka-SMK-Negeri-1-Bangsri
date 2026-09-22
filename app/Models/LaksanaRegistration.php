<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaksanaRegistration extends Model
{
    use HasFactory;

    protected $table = 'laksana_registrations';

    protected $fillable = [
        'nama',
        'nta',
        'kelas',
        'jenis_kelamin',
        'rt',
        'rw',
        'kecamatan',
        'kabupaten',
        'tempat_tanggal_lahir',
        'motivasi',
        'whatsapp',
        'nomor_orang_tua',
        'surat_izin_path',
        'status_verifikasi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
