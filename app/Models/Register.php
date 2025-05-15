<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Register extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'result',
        'detail',
        'date',
        'course_id',
        'personnel_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function personnel()
    {
        return $this->belongsTo(Personnel::class,'personnel_id');
    }

}
