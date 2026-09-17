<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    use HasFactory;

    protected $table = 'timeline_events';

    protected $fillable = [
        'title',
        'date',
        'time',
        'location',
        'guide_url',
        'theme',
        'status',
        'is_active',
        'sort_order',
        'logo_path',
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
