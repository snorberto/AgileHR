<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_information_types')->insert([
            //string('ContactType');
            'ContactType' => 'Phone - 1'
        ]);

        DB::table('contact_information_types')->insert([
            //string('ContactType');
            'ContactType' => 'Phone - 2'
        ]);

        DB::table('contact_information_types')->insert([
            //string('ContactType');
            'ContactType' => 'Email'
        ]);
    }
}
