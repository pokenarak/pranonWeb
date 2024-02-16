<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'topic',
        'detail',
        'user_id',
        'date'
    ];
    public function user()
    {
        return $this->belongsToMany(User::class,'user_id');
    }

    public function image()
    {
        return $this->hasMany(image::class);
    }
    public function lastestImage()
    {
        return $this->hasOne(image::class)->latestOfMany();
    }
}
