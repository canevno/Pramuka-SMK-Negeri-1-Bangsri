<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'participant_id',
        'participant_name',
        'participant_kelas',
        'participant_ambalan',
        'status',
        'iuran',
        'bulan',
        'tanggal',
        'tahun',
        'week_label',
        'month_key',
        'year_key',
        'record_date',
        'petugas_name',
        'petugas_kelas',
        'petugas_nta',
    ];
}