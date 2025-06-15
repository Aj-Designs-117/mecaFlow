<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'slug'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('category')
            ->dontSubmitEmptyLogs();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
