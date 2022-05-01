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
            $table->unsignedInteger('opener_id')->nullable(false);
            $table->unsignedInteger('sprint_id')->nullable(true);
            $table->integer('story_points')->nullable(true);
            $table->string('Title')->nullable(false);
            //$table->string('team');
            $table->unsignedInteger('position_status')->nullable(true);
            $table->string('Description', 10000)->nullable(false);
            $table->unsignedInteger('assignee_id')->nullable(true);
            $table->string('attachment')->nullable(true);
            $table->unsignedInteger('PriorityOrder')->nullable(false);
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
