<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payment_logs', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->integer('month');
            $table->integer('user_id');
            $table->integer('admin_id')->nullable();
            $table->float('payment', 12, 2);
            $table->tinyInteger('payment_status')->default(0)->comment('0:no_pay, 1:payed, 2:suspend');
            $table->timestamp('payment_time')->nullable();
            $table->tinyInteger('del_flag')->nullable()->default(0)->comment('0: active, 1: delete (default: 0)');
            $table->timestamps();
            $table->index('month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_payment_logs');
    }
}
