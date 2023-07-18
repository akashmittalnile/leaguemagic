<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('conference_id')->unsigned()->nullable();
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('reagions')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('player_import')->nullable();
            $table->string('title', 500)->nullable();
            $table->string('schedule_code')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('clubs');
    }
}
