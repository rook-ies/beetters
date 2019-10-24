<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('idapt');
          $table->string('name');
          $table->string('application_file_name');
          $table->binary('application_icon');
          $table->timestamps();
          $table->foreign('idapt')->references('id')->on('app_productivity_type')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application');
    }
}
