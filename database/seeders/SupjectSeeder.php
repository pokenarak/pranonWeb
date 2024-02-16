<?php

namespace Database\Seeders;

use App\Models\Supject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Supject::count()==0) {

            $data=[
                ['name'=>'นักธรรมตรี','type'=>'นักธรรม'],
                ['name'=>'นักธรรมโท','type'=>'นักธรรม'],
                ['name'=>'นักธรรมเอก','type'=>'นักธรรม'],
                ['name'=>'ธรรมศึกษาตรี','type'=>'ธรรมศึกษา'],
                ['name'=>'ธรรมศึกษาโท','type'=>'ธรรมศึกษา'],
                ['name'=>'ธรรมศึกษาเอก','type'=>'ธรรมศึกษา'],
                ['name'=>'ประโยค ๑-๒','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๓','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๔','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๕','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๖','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๗','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๘','type'=>'บาลี'],
                ['name'=>'ประโยค ป.ธ. ๙','type'=>'บาลี'],
                ['name'=>'บาลีศึกษา ๑-๒','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๓','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๔','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๕','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๖','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๗','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๘','type'=>'บาลีศึกษา'],
                ['name'=>'บาลีศึกษา ๙','type'=>'บาลีศึกษา'],
            ];
            Supject::insert($data);
        }
    }
}
