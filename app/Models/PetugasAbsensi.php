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
        'jumlah_rekam',
    ];

    /**
     * Cast fields to native types
     */
    protected $casts = [
        'jumlah_rekam' => 'integer',
    ];

    /**
     * Relasi ke model AttendanceRecord berdasarkan NTA
     */
    public function attendanceRecords()
    {
        // Parameter: (ModelTujuan, FK_di_AttendanceRecord, PK_di_PetugasAbsensi)
        return $this->hasMany(AttendanceRecord::class, 'petugas_nta', 'nta');
    }
}