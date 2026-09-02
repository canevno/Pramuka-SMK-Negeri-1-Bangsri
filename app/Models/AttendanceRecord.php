<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan',
        'tanggal',
        'tahun',
        'participant_id',
        'participant_name',
        'participant_kelas',
        'participant_ambalan',
        'status',
        'iuran',
        'petugas_name',
        'petugas_kelas',
        'petugas_nta',
        'week_label',
        'month_key',
        'year_key',
        'record_date',
    ];
}