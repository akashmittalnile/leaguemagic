<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProgramClubDivisionSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_club_division_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("program_club_division_id")->nullable();
            $table->string("age_group")->nullable();
            $table->string("playdown_age_group")->nullable();

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
        Schema::dropIfExists('table_program_club_division_settings');
    }
}
