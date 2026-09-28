<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorDevice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'blocked_at' => 'datetime',
        'visit_count' => 'integer',
    ];

    protected $appends = ['is_blocked'];

    public function getIsBlockedAttribute(): bool
    {
        return ! empty($this->blocked_at);
    }
}
