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
            $table->unsignedInteger('sprint_id');
            $table->integer('story_points');
            //$table->string('team');
            $table->unsignedInteger('position_status');
            $table->string('Description');
            $table->unsignedInteger('assignee_id');
            $table->binary('attachment');
            $table->unsignedInteger('PriorityOrder');
            $table->timestamps();

            /*$table->foreign('opener_id')->references('ID')->on('Users');
            $table->foreign('sprint_id')->references('ID')->on('Sprints');
            $table->foreign('assignee_id')->references('ID')->on('Roles');
            $table->foreign('position_status')->references('ID')->on('position_statuses');*/
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
