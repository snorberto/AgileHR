<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->insert([
            //string('RoleDescription');
            'RoleDescription' => 'HR Sourcer'
        ]);

        DB::table('role_permissions')->insert([
            //string('RoleDescription');
            'RoleDescription' => 'HR Recruiter'
        ]);

        DB::table('role_permissions')->insert([
            //string('RoleDescription');
            'RoleDescription' => 'HR Generalist'
        ]);

        DB::table('role_permissions')->insert([
            //string('RoleDescription');
            'RoleDescription' => 'Scrum Master'
        ]);

        DB::table('role_permissions')->insert([
            //string('RoleDescription');
            'RoleDescription' => 'Hiring Manager'
        ]);

        DB::table('role_permissions')->insert([
            //string('RoleDescription');
            'RoleDescription' => 'Admin'
        ]);
    }
}
