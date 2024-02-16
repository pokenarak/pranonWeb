<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacter extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'personnel_id',
        'detail',
        'salary',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
