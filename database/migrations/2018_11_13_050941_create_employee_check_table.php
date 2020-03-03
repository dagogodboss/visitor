<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_check', function (Blueprint $table) {
            $table->increments('id');

            $table->string('employee_id')->nullable();
            $table->string('date')->nullable();
            $table->integer('status')->nullable();
            $table->string('checkin')->nullable();
            $table->string('checkout')->nullable();
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
        Schema::dropIfExists('employee_check');
    }
}
