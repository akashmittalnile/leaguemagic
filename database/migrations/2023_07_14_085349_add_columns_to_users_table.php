<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('address_line1')->nullable()->after('email');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('city')->nullable()->after('address_line2');
            $table->string('zipcode')->nullable()->after('city');
            $table->integer('state_id')->nullable()->unsigned()->after('zipcode');
            $table->integer('position_id')->nullable()->unsigned()->after('state_id');
            $table->string('IsActive')->nullable()->after('position_id');
            $table->string('user_type')->nullable()->after('IsActive');
            $table->string('hourly_rate')->nullable()->after('user_type');
            $table->string('mileage_rate')->nullable()->after('hourly_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
