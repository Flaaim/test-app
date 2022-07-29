<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname'=> 'admin',
            'lastname' => 'admin',
            'email'=> 'admin@admin.com',
            'password'=> bcrypt('admin'),
        ]);
    }
}
