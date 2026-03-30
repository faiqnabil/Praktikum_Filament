<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'color',
        'image',
        'body',
        'tags',
        'published',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}