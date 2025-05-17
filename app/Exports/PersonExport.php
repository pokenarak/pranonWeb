<?php

namespace App\Exports;

use App\Models\Personnel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PersonExport implements FromQuery,WithMapping,WithHeadings,WithColumnFormatting
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $type;
    public function __construct($type)
    {
        $this->type = $type;
    }
    public function query()
    {
        $person = Personnel::where('active','1');
        if($this->type === 'monk'){
            $person = $person->whereNotNull('ordain_monk')->orderBy('ordain_monk');
        }else{
            $person = $person->whereNull('ordain_monk')->whereNotNull('ordain_novice')->orderBy('birthday');
        }
        return $person;
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
    public function prepareRows($rows){
        return $rows->transform(function ($student){
            $student->people_id =  Crypt::decryptString($student->people_id);
            $student->birthday = Carbon::parse($student->birthday)->age;
            $student->ordain_monk = Carbon::parse($student->ordain_monk)->age;
            return $student;
        });
    }
     public function columnFormats(): array{
        return[
            'A'=> NumberFormat::FORMAT_NUMBER,
        ];
    }
}
