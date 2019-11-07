<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poke', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_team');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_team')->references('id')->on('TEAM')->change();
            $table->foreign('id_user')->references('id')->on('USERS')->change();
            $table->string('content');
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
        Schema::dropIfExists('poke');
    }
}
