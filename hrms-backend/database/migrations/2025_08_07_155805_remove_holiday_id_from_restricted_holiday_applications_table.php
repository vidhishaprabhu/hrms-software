<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveHolidayIdFromRestrictedHolidayApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restricted_holiday_applications', function (Blueprint $table) {
            $table->dropForeign(['holiday_id']);
            $table->dropColumn('holiday_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restricted_holiday_applications', function (Blueprint $table) {
            //
        });
    }
}
