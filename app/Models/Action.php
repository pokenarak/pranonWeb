<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    public static $ACTIVITY = 'กิจกรรม',$COURSE = 'การสอน',$IMAGE = 'รูปภาพกิจกรรม',$NEWS = 'ประชาสัมพันธ์',$PERSONNEL = 'บุคลากร',$PERSONNEL_TYPE = 'ประเภทบุคลากร',
                $PILGRIMAGE = 'ธุดงค์',$RAINS_RETREAT='จำพรรษา', $REGISTER = 'ลงทะเบียน',$STOP_IMAGE = 'รูปภาพธุดงค์',
                $STOP = 'จุดหมายธุดงค์',$SUPJECT = 'วิชา',$TEACHER = 'ครูสอน',$TYPE='ตำแหน่งบุคลากร',$USER='ผู้ดูแลระบบ';
    public static $DELETE_ACTION = 1,$INSERT_ACTION = 2,$UPDATE_ACTION = 3;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'id_table_action',
        'action',
        'table_name',
        'date'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function personnel(){
        return $this->hasManyThrough(
            Personnel::class,
            User::class
        );
    }

}
