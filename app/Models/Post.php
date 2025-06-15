<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{
    use LogsActivity;

    protected $fillable = ['user_id', 'title', 'slug', 'excerpt', 'body', 'partners', 'status'];
    protected $casts = ['partners' => 'array'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('post')
            ->dontSubmitEmptyLogs();
    }

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
}
