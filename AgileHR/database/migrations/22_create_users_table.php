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
           $table->string('email');
           $table->unsignedInteger('RoleID')->nullable(false);           
           $table->integer('isAdmin')->default(0);
           $table->string('remember_token', 100)->nullable(true);
           $table->timestamps();

           /*$table->foreign('RoleID')->references('ID')->on('Roles');*/
           
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
