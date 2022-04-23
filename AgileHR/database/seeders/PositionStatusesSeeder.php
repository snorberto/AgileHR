<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('position_statuses')->insert([
            //string('PositionStatus');
            'PositionStatus' => 'To be opened'
        ]);

        DB::table('position_statuses')->insert([
            //string('PositionStatus');
            'PositionStatus' => 'Open'
        ]);

        DB::table('position_statuses')->insert([
            //string('PositionStatus');
            'PositionStatus' => 'Filled'
        ]);

        DB::table('position_statuses')->insert([
            //string('PositionStatus');
            'PositionStatus' => 'Closed'
        ]);
        
        DB::table('position_statuses')->insert([
            //string('PositionStatus');
            'PositionStatus' => 'Cancelled'
        ]);

        DB::table('position_statuses')->insert([
            //string('PositionStatus');
            'PositionStatus' => 'On hold'
        ]);
    }
}
