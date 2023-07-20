<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStaffTimeCardExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_time_card_expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("staff_time_card_id")->unsigned()->nullable();
            $table->string("expenses_type")->nullable();
            $table->string("expenses")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('table_staff_time_card_expenses');
    }
}
