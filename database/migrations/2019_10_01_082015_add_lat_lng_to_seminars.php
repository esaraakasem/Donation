<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatLngToSeminars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->double('lat', 10, 8)->nullable();
            $table->double('lng', 10, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seminars', function (Blueprint $table) {
            //
        });
    }
}
