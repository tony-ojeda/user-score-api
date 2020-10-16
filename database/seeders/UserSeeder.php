<?php

namespace Database\Seeders;

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
        DB::table('users')->insert(['name' => 'Tony','email'=>'tojeda96@gmail.com','email_verified_at'=>'tojeda96@gmail.com','password'=>Hash::make('123'),'remember_token'=>Hash::make(microtime())]);//ti_admin
        DB::table('users')->insert(['name' => 'Andres Salas','email'=>'jhon1.admin@gmail.com','email_verified_at'=>'2020-08-18 10:15_25','password'=>Hash::make('password'),'remember_token'=>Hash::make(microtime())]);//ti_admin
        DB::table('users')->insert(['name' => 'María Dina','email'=>'jhon2.admin@gmail.com','email_verified_at'=>'2020-08-18 10:15_25','password'=>Hash::make('password'),'remember_token'=>Hash::make(microtime())]);//rt_admin
    }
}
