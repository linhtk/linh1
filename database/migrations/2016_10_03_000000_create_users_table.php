<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->string('name',255);
            $table->string('email',255)->unique();
            $table->string('password',255);
            $table->string('tel',255);
            $table->string('cmt_no',20);
            $table->date('cmt_date');
            $table->string('cmt_local',255);
            $table->string('address',255);
            $table->string('bank_name',255)->nullable();
            $table->string('bank_branch_name',255)->nullable();
            $table->string('bank_account_number',255)->nullable();
            $table->string('bank_account_name',255)->nullable();
            $table->bigInteger('points')->nullable()->default(0);
            $table->string('media_user_id',128)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment('0: inactive, 1: actived, 2: deleted (default: 0)');
            $table->string('remember_token',255)->nullable();
            $table->timestamps();

            // $table->index('bank_name');
            // $table->index('bank_account_number');
            $table->index('name');
            $table->index('email');
            $table->index('cmt_no');
            $table->index('media_user_id');
            $table->index('points');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
