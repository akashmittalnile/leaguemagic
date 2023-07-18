<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTimeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_time_cards', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->date('workdate')->nullable();
            $table->string('mileage')->nullable();
            $table->string('expense_type')->nullable();
            $table->float('expense')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('work_units')->nullable();
            $table->string('comments', 500)->nullable();
            $table->string('email_address', 500)->nullable();
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
        Schema::dropIfExists('staff_time_cards');
    }
}
