<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatroom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CHATROOM', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_code');
            $table->string('room_name');
            $table->time('business_hour_start');
            $table->time('business_hour_end');
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
        Schema::dropIfExists('CHATROOM');
    }
}
