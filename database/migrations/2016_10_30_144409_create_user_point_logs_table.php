<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPointLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_point_logs', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->integer('promotion_id');
            $table->integer('action_id');
            $table->integer('thanks_id');
            $table->integer('user_id');
            $table->string('media_user_id');
            $table->tinyInteger('payment_type')->comment('0:fixed, 1:percent');
            $table->tinyInteger('accept')->default(0)->comment('0:unconfirmed, 1:accept, 2:reject ');
            $table->float('price', 12, 2);
            $table->timestamp('accept_time')->nullable();
            $table->timestamp('action_time')->nullable();
            $table->tinyInteger('del_flag')->nullable()->default(0)->comment('0: active, 1: delete (default: 0)');
            $table->timestamps();
            $table->index('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_point_logs');
    }
}
