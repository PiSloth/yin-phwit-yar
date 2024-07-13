<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function audienceLevel()
    {
        return $this->belongsTo(AudienceLevel::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->hasOne(Content::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
