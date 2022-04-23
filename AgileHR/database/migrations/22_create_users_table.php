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
        Schema::create('users', function (Blueprint $table) {
           $table->increments('ID');
           $table->string('Name')->nullable(false);
           $table->string('username')->nullable(false);
           $table->string('password', 100)->nullable(false);
           $table->unsignedInteger('RoleID')->nullable(false);           
           $table->binary('isAdmin')->default(0);
           $table->timestamps();

           $table->foreign('RoleID')->references('ID')->on('Roles');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
