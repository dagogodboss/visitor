<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('address')->nullable();
            $table->string('site_key')->nullable();
            $table->integer('notifications_email')->nullable();
            $table->integer('notifications_sms')->nullable();
            $table->string('api_username')->nullable();
            $table->string('api_key')->nullable();
            $table->string('notify_templates')->nullable();
            $table->integer('visitor_img_capture')->nullable();
            $table->integer('employ_img_capture')->nullable();
            $table->string('id_card_logo')->nullable();
            $table->string('agreement_screen')->nullable();
            $table->string('welcome_screen')->nullable();
            $table->string('invite_templates')->nullable();
            $table->integer('visitor_agreement')->nullable();
            $table->integer('front_end_enable_disable')->nullable();
            $table->integer('id_card')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
