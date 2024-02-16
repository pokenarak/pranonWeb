<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'lastname',
        'ordianation_name',
        'people_id',
        'address',
        'position',
        'tel',
        'birthday',
        'ordain_novice',
        'ordain_monk',
        'ordain_nun',
        'old_temple_name',
        'old_temple_tel',
        'active',
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function register()
    {
        return $this->hasMany(Register::class);
    }
    public function teacher()
    {
        return $this->hasMany(Teacter::class);
    }
    public function rank()
    {
        return $this->hasMany(Rank::class);
    }
    public function type()
    {
        return $this->hasMany(Type::class);
    }
    public function rainsRetreat()
    {
        return $this->hasMany(RainsRetreat::class);
    }

}
