<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTrackingHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_tracking_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_tracking_history');
            $table->unsignedBigInteger('id_application');
            $table->foreign('id_tracking_history')->references('id')->on('tracking_history')->change();
            $table->foreign('id_application')->references('id')->on('application')->change();
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
        Schema::dropIfExists('application_tracking_history');
    }
}
