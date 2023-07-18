<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_slots', function (Blueprint $table) {
            $table->id();
            $table->integer('program_id',)->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->string('apply_time', 45)->nullable();
            $table->string('custom_slots', 200)->nullable();
            $table->integer("status")->nullable();
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
        Schema::dropIfExists('program_slots');
    }
}
