<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClickLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_logs', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->bigInteger('user_id');
            $table->bigInteger('campaign_id');
            $table->bigInteger('thank_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('campaign_id');
            $table->index('thank_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('click_logs');
    }
}
