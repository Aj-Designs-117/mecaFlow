<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'excerpt', 'body', 'partners', 'status'];
    protected $casts = [
        'partners' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function postImages()
    {
        return $this->hasMany(PostImage::class);
    }

    protected static function booted()
    {
        static::created(function ($post) {
            Audit::create([
                'post_id' => $post->id,
                'action' => 'CREATED',
                'new_title' => $post->title,
                'new_date' => $post->created_at,
                'user_id' => auth()->id(),
            ]);
        });

        static::updated(function ($post) {
            Audit::create([
                'post_id' => $post->id,
                'action' => 'UPDATED',
                'old_title' => $post->getOriginal('title'),
                'new_title' => $post->title,
                'old_date' => $post->getOriginal('updated_at'),
                'new_date' => $post->updated_at,
                'user_id' => auth()->id(),
            ]);
        });


        static::deleted(function ($post) {
            Audit::create([
                'post_id' => $post->id,
                'action' => 'DELETED',
                'old_title' => $post->title,
                'old_date' => $post->updated_at,
                'user_id' => auth()->id(),
            ]);
        });
    }
}
