<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherMoreDetailsToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('father_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->boolean('physically_challenged')->default(false);
            $table->string('state')->nullable();
            $table->string('pin')->nullable();
            $table->date('confirmation_date')->nullable();
            $table->enum('employee_type', ['Permanent', 'Probation', 'Intern'])->nullable();
            $table->integer('probation_period_days')->nullable();            
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
