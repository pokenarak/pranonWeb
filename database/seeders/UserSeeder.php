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
            'email'=>'apst2535@gmail.com',
            'username'=>'admin',
            'password'=> Hash::make('12345678'),
            'role'=>User::$SUPER_ADMIN,
            'personnel_id'=>1,
        ]);
    }
}
