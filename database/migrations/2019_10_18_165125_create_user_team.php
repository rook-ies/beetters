<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_team', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_team');
            $table->unsignedBigInteger('id_role');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->change();
            $table->foreign('id_team')->references('id')->on('team')->change();
            $table->foreign('id_role')->references('id')->on('role')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_team');
    }
}
