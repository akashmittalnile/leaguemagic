<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProgramClubDivisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_club_divisions', function (Blueprint $table) {
            $table->id();
            $table->integer("program_id")->nullable();
            $table->integer("club_id")->nullable();
            $table->integer("division_id")->nullable();
            $table->integer("group_id")->nullable();
            $table->integer("level_id")->nullable();
            $table->string("description")->nullable();


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
        Schema::dropIfExists('table_program_club_divisions');
    }
}
