<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RegisterExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $year;
    public function __construct($year){
        $this->year = $year;
    }
    public function sheets(): array
    {
        $palis = Course::where('year',$this->year)->whereHas('supject',function ($q){
            $q->where('type','like','%บาลี%');
        })->get();
        
       $sheets = [];
       foreach ($palis as $course) {
            $sheets[]= new CourseSheetExport($course);
       }
       return $sheets;
    }
}
