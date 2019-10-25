<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyScrumReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DAILY_SCRUM_REPORT', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_chatroom');
            $table->unsignedBigInteger('id_user');
            $table->string('last_24_hour_activities');
            $table->string('next_24_hour_activities');
            $table->foreign('id_chatroom')->references('id')->on('CHATROOM')->change();
            $table->foreign('id_user')->references('id')->on('USERS')->change();
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
        Schema::dropIfExists('DAILY_SCRUM_REPORT');
    }
}
