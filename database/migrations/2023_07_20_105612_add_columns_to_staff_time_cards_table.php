<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStaffTimeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_time_cards', function (Blueprint $table) {
            $table->string('total_amount')->nullable()->after('work_units');
            $table->string('location')->nullable()->after('mileage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_time_cards', function (Blueprint $table) {
            //
        });
    }
}
