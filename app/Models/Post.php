<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'excerpt' ,'body', 'partners', 'status'];
    protected $casts = [
        'partners' => 'array', 
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function postImages()
    {
        return $this->hasMany(PostImage::class);
    }
}
