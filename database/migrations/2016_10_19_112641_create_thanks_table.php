<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thanks', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->integer('campaign_id');
            $table->integer('promotion_id');
            $table->integer('thanks_id');
            $table->string('thanks_name', 255);
            $table->integer('thanks_type');
            $table->integer('normal_price')->nullable()->default(0);
            $table->integer('special_price')->nullable()->default(0);
            $table->tinyInteger('delete_flag')->nullable()->default(0)->comment('0: active, 1: delete (default: 0)');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unique(['promotion_id', 'thanks_id']);
            $table->index('campaign_id');
            $table->index('promotion_id');
            $table->index('thanks_id');
            $table->index('thanks_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thanks');
    }
}
