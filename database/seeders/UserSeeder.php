<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Admin',
            'email'=>'watpranonjaksri@outlook.com',
            'password'=> Hash::make('12345678'),
            'role'=>'SUPER_ADMIN',
            'personnel_id'=>0
        ]);
        DB::table('users')->insert([
            'name'=>'Admin',
            'email'=>'Katoyota_001@hotmail.com',
            'password'=> Hash::make('12345678'),
            'role'=>'SUPER_ADMIN',
            'personnel_id'=>0
        ]);
    }
}
