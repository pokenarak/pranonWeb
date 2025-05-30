<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'personnel_id',
        'personnel_type_id'
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class,'personnel_id');
    }
    public function personnel_type()
    {
        return $this->belongsTo(personnel_type::class,'personnel_type_id');
    }
}
