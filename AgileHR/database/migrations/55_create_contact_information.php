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
        Schema::create('contact_information', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('contact_type_id');
            $table->string('ContactInfo_value');            
            $table->timestamps();

            /*$table->foreign('candidate_id')->references('ID')->on('candidate_details');
            $table->foreign('contact_type_id')->references('ID')->on('contact_information_types');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_information');
    }
};
