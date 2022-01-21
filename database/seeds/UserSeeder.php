<?php

use Illuminate\Database\Seeder;
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
            'code'       => '01HY00001',
            'firstname'  => 'admin',
            'lastname'   => 'Quang Bui',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make(env('PASSWORD_DEFAULT')),
            'phone'      => '0987654321',
            'birthday'   => date('Y-m-d H:i:s', time()),
            'area'       => 1,
            'img'        => env('AVATAR_DEFAULT'),
            'jointime'   => date('Y-m-d H:i:s', time()),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
