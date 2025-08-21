<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreDetailsToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('blood_group', 5)->nullable()->after('date_of_joining');
            $table->string('city', 100)->nullable()->after('blood_group');
            $table->string('address', 255)->nullable()->after('city'); 
            $table->string('emergency_contact', 15)->nullable()->after('address'); 
            $table->text('other_details')->nullable()->after('emergency_contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
}
