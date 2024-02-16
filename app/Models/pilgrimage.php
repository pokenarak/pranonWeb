<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pilgrimage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start',
        'end',
        'stage',
        'detail',
        'user_id'
    ];

    public function stop()
    {
        return $this->hasMany(stop::class);
    }
    public function stopImage()
    {
        return $this->hasManyThrough(
            stopImage::class,
            stop::class
        );
    }
    public function firstStop()
    {
        return $this->hasOne(stop::class)->oldestOfMany();
    }
}
