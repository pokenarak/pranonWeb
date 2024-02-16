<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
    ];

    public function teacher()
    {
        return $this->hasMany(Teacter::class,'supject_id');
    }
    public function course()
    {
        return $this->hasMany(Course::class,'supject_id');
    }
    public function register()
    {
        return $this->hasManyThrough(
            Register::class,
            Course::class
        );
    }
}
