<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('category', ['مال', 'ملابس', 'مواد غذائية', 'أدوات مدرسية']);
            $table->enum('status', ['accept', 'refuse', 'visit'])->nullable();
            $table->enum('type', ['one_time', 'three_months', 'one_month', 'one_week', 'three_minutes'])->nullable();
            $table->string('requested_price')->nullable();
            $table->string('sent_price')->nullable();
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->integer('age')->nullable();
            $table->string('size')->nullable();
            $table->string('school_year')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('donations');
    }
}
