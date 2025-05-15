<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'supject_id',
        'room'
    ];

    public function register()
    {
        return $this->hasMany(Register::class);
    }
    public function supject()
    {
        return $this->belongsTo(Supject::class,'supject_id');
    }
    public function teacher()
    {
        return $this->hasMany(Teacter::class);
    }
}
