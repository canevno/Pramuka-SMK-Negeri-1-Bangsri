<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $table = 'gallery_items';

    protected $fillable = [
        'title',
        'category',
        'group',
        'location',
        'image',
        'description',
        'alt_text',
        'published_at',
        'is_published',
        'is_featured',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'date',
    ];

    protected $attributes = [
        'group' => 'umum',
    ];
}
