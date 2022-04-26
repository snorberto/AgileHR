<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_positions_relationship', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('position_id');
            $table->unsignedInteger('candidate_status_id');
            $table->unsignedInteger('position_status_id');
            $table->unsignedInteger('assignee_id');
            $table->string('Comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_positions_relationship');
    }
};
