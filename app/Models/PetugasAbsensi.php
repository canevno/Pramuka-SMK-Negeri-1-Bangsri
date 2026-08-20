<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasAbsensi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'petugas_absensis';

    protected $fillable = [
        'nama',
        'nta',
        'kelas_petugas',
        'is_approved',
        'is_active',
        'terakhir_melakukan',
    ];
}