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
        Schema::create('Roles', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('RoleName')->nullable(false);
            $table->unsignedInteger('Permission_id');
            $table->timestamps();
           

            /*$table->foreign('Permission_id')->references('ID')->on('role_permissions');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Roles');
    }
};
