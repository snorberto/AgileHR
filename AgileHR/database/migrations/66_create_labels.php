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
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('label_type_id');
            $table->timestamps();

            $table->foreign('candidate_id')->references('ID')->on('candidate_details');
            $table->foreign('label_type_id')->references('ID')->on('label_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels');
    }
};
