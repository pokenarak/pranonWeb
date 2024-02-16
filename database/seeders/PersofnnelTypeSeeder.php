<?php

namespace Database\Seeders;

use App\Models\Personnel_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersofnnelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Personnel_type::count()==0) {

            $data=[
                ['name'=>'เจ้าอาวาส'],
                ['name'=>'รองเจ้าอาวาส'],
                ['name'=>'ผู้ช่วยเจ้าอาวาส'],
                ['name'=>'อาจารย์ใหญ่สำนักเรียน'],
                ['name'=>'ไวยาวัจกร'],
                ['name'=>'เจ้าคณะจังหวัด'],
                ['name'=>'รองเจ้าคณะจังหวัด'],
                ['name'=>'เจ้าคณะอำเภอ'],
                ['name'=>'รองเจ้าคณะอำเภอ'],
                ['name'=>'เจ้าคณะตำบล'],
                ['name'=>'รองเจ้าคณะตำบล'],
            ];
            Personnel_type::insert($data);
        }
    }
}
