<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Course extends Model
{
    use HasFactory;
    use Authorizable;

    protected $fillable = ["title", "description"];

    protected $appends = ['permission'];

    protected  function permission(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->can('update-course', $this),
        );
    }

    protected static function booted()
    {
        static::creating(function ($course) {
            $course->user_id = auth()->user()->id;
        });
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
