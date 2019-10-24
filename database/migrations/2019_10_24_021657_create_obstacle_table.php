<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObstacleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obstacle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_daily_scrum_report');
            $table->string('content');
            $table->foreign('id_daily_scrum_report')->references('id')->on('DAILY_SCRUM_REPORT')->change();
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
        Schema::dropIfExists('obstacle');
    }
}
