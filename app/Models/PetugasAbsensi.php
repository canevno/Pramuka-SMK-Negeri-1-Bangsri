<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasAbsensi extends Model
{
    use HasFactory;

    protected $table = 'petugas_absensis';

    protected $fillable = [
        'nama',
        'nta',
        'kelas_petugas',
        'jenis_kelamin',
        'status',
        'jumlah_rekam',
        'is_active',
        'is_approved',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_approved'  => 'boolean',
        'jumlah_rekam' => 'integer',
    ];
}