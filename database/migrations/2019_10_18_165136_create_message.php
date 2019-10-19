<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MESSAGE', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idu');
            $table->unsignedBigInteger('idc');
            $table->string('content');
            $table->timestamps();
            $table->foreign('idu')->references('id')->on('USER')->change();
            $table->foreign('idc')->references('id')->on('CHATROOM')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MESSAGE');
    }
}
