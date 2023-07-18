<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReagionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reagions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('confefrence_id')->unsigned()->nullable();
            $table->foreign('confefrence_id')->references('id')->on('conferences')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('reagions');
    }
}
