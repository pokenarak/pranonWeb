<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RainsRetreat extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'personnel_id',
        'year',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class,'personnel_id');
    }
}
