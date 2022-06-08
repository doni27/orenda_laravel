<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\User;

class user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user           = new \App\Models\User;
        $user->name     = "admin";
        $user->email    = "admin@gmail.com";
        $user->password = bcrypt('123456');
        $user->save();
    }
}
