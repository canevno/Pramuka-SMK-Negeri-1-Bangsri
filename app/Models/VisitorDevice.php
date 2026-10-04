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

    protected $appends = ['is_blocked', 'is_active'];

    public function getIsBlockedAttribute(): bool
    {
        return ! empty($this->blocked_at);
    }

    public function getIsActiveAttribute(): bool
    {
        if ($this->is_blocked) {
            return false;
        }

        if (! $this->last_seen_at) {
            return false;
        }

        return $this->last_seen_at->greaterThanOrEqualTo(now()->subMinutes(5));
    }
}
