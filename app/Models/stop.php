<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stop extends Model
{
    use HasFactory;
    protected $fillable = [
        'pilgrimage_id',
        'no',
        'detail',
        'date'
    ];

    public function pilgrimage()
    {
        return $this->belongsTo(pilgrimage::class,'pilgrimage_id');
    }
    public function stopImage()
    {
        return $this->hasMany(stopImage::class);
    }
}
