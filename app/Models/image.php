<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'path',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id');
    }
}
