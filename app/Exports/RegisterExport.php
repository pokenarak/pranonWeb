<?php

namespace App\Exports;

use App\Models\Course;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RegisterExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $year,$type;
    public function __construct($year,$type){
        $this->year = $year;
        $this->type = $type;
        
    }
    public function sheets(): array
    {
        $t=$this->type;
        $palis = Course::where('year',$this->year)->whereHas('supject',function ($q) use ($t){
            $q->where('type','like','%'.$t.'%');
        })->get();
        
       $sheets = [];
       foreach ($palis as $course) {
            $sheets[]= new CourseSheetExport($course);
       }
       return $sheets;
    }
}
