<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('account_access')->nullable();
            $table->string('admin_badge')->nullable();
            $table->string('position_ratio')->nullable();
            $table->string('badge_color')->nullable();
            $table->string('badge_color_hex')->nullable();
            $table->string('text_color')->nullable();
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
        Schema::dropIfExists('positions');
    }
}
