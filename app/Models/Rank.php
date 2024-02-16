<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'personnel_id',
        'name',
        'date',
    ];

    public function Personnel()
    {
        return $this->belongsTo(Personnel::class,'personnel_id');
    }
}
