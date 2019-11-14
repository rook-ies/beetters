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
        Schema::create('daily_scrum_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_team');
            $table->unsignedBigInteger('id_user');
            $table->string('last_24_hour_activities');
            $table->string('next_24_hour_activities');
            $table->foreign('id_team')->references('id')->on('team')->change();
            $table->foreign('id_user')->references('id')->on('users')->change();
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
        Schema::dropIfExists('daily_scrum_report');
    }
}
