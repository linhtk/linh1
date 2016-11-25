<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignPromotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_promotes', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->integer('campaign_id');
            $table->integer('id_thanks');
            $table->tinyInteger('type')->comment('0: Spot light, 1: Recommended (Default: 0)');
            $table->integer('order');
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
        Schema::drop('campaign_promotes');
    }
}
