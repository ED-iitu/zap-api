<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin',
            'display_name' => 'admin',
        ]);

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'role_id' => 1,
            'email' => "admin@admin.com",
            'password' => Hash::make('password'),
            'phone' => '87717777777',
        ]);
    }
}
