<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTrackingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_tracking_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idu');
            $table->double('productive_value', 6, 2);
            $table->double('netral_value', 6, 2);
            $table->double('not_productive_value', 6, 2);
            $table->foreign('idu')->references('id')->on('USERS')->change();
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
        Schema::dropIfExists('daily_tracking_report');
    }
}
