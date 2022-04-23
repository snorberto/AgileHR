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
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('opener_id');
            $table->string('sprint_label');
            $table->integer('story_points');
            //$table->string('team');
            $table->unsignedInteger('ticket_status');
            $table->string('Description');
            $table->unsignedInteger('assignee_id');
            $table->binary('attachment');
            $table->timestamps();

            $table->foreign('opener_id')->references('ID')->on('Users');
            $table->foreign('assignee_id')->references('ID')->on('Roles');
            $table->foreign('ticket_status')->references('ID')->on('ticket_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
};
