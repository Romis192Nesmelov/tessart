<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['email' => 'info.tessart@gmail.com','password' => bcrypt('infotessart')],
            ['email' => 'romis.nesmelov@gmail.com','password' => bcrypt('apg192')]
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}