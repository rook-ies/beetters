<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdaptColumnInApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application', function (Blueprint $table) {
              $table->renameColumn('idapt', 'id_app_productivity_type');
              $table->foreign('id_app_productivity_type')->references('id')->on('app_productivity_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application', function (Blueprint $table) {
          $table->renameColumn('id_app_productivity_type','idapt');
          $table->foreign('idapt')->references('id')->on('app_productivity_type');
        });
    }
}
