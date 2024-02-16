<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stopImage extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'stop_id',
        'path'
    ];

    public function stop()
    {
        return $this->belongsTo(Stop::class,'stop_id');
    }

}
