<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantaraRegistration extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'bantara_registrations';

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
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

    /**
     * Cast atribut ke tipe data spesifik.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}