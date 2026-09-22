<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'type', 'is_read', 'url', 'data'];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
    ];
}
