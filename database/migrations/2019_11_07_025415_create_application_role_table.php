<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_application');
            $table->foreign('id_role')->references('id')->on('ROLE')->change();
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
        Schema::dropIfExists('application_role');
    }
}
