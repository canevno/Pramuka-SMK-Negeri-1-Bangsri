<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = ['visit_date', 'visitor_hash', 'hits', 'last_path'];

    protected $casts = [
        'visit_date' => 'date',
    ];
}