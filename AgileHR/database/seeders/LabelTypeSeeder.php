<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'Java developer'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'C# Developer'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'Data Engineer'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'Data Scientist'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'Python Developer'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'Frontend developer'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'Backend Developer'
        ]);

        DB::table('label_types')->insert([
            //string('Label_value');
            'Label_value' => 'UX Designer'
        ]);
    }
}
