<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RoleID = DB::table('role_permissions')->select('ID')->where('RoleDescription', 'Admin')->first();
        DB::table('users')->insert([
            'Name' => Str::random(10),
            'username' => "admin",
            'email' => "admin".'@yourcompany.com',
            'password' => Hash::make('password'),
            'RoleID' => $RoleID->ID,
            'isAdmin' => 1,
        ]);
    }
}
