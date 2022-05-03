<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Applied'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Phone interview'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => '1st technical interview'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => '2nd technical interview'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Offer Sent'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Accepted offer'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Declined offer'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Onboarding - medical examination'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Onboarding - contract signing'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Onboarding - contract signed'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Withdrew'
        ]);

        DB::table('candidate_status')->insert([
            //string('TicketStatus');
            'CandidateStatus' => 'Rejected'
        ]);
    }
}
