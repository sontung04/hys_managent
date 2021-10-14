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
            'name'       => 'admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make(env('PASSWORD_DEFAULT')),
            'phone'      => '0987654321',
            'birthday'   => date('d-m-Y', time()),
            'img'        => 'url img',
            'jointime'   => time(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}
