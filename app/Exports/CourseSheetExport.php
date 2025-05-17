<?php

namespace App\Exports;

use App\Models\Personnel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class CourseSheetExport implements WithTitle,WithHeadings, FromQuery, WithMapping, WithColumnFormatting
{
    private $course;

    public function __construct($course){
        $this->course = $course;
    }

    public function title():string{
        return $this->course->supject->name;
    }
    public function headings ():array{
        return [
            'เลขบัตรประจำตัวประชาชน',
            'ชื่อ',
            'ฉายา',
            'นามสกุล',
            'อายุ',
            'พรรษา'
            
        ];
    }
    public function query(){
        $id = $this->course->id;
        $students = Personnel::whereHas('register',function ($q) use ($id){
            $q->where('course_id',$id);
        });
       
        return $students;
    }
    public function prepareRows($rows){
        return $rows->transform(function ($student){
            if($student['ordain_monk']){
                $student->name ='พระ'.$student->name;
            }else if($student['ordain_novice']){ 
                $student->name ='สามเณร'.$student->name;
            }else{
                 $student->name = $student->name;
            }
            $student->people_id =  Crypt::decryptString($student->people_id);
            $student->birthday = Carbon::parse($student->birthday)->age;
            $student->ordain_monk = Carbon::parse($student->ordain_monk)->age;
            return $student;
        });
    }

    public function map($row):array{
        
        return [
            $row['people_id'],
            $row['name'],
            $row['ordianation_name'],
            $row['lastname'],
            $row['birthday'],
            $row['ordain_monk']
        ];
       
    }
    public function columnFormats(): array{
        return[
            'A'=> NumberFormat::FORMAT_NUMBER,
        ];
    }
}
