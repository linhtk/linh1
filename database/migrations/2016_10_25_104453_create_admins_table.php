<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('role_id')->nullable()->default(0)->comment('0: member, 1: admin (default: 0)');
            $table->string('email',128)->unique();
            $table->string('password',128);
            $table->string('firstname',64);
            $table->string('lastname',64);
            $table->string('memo',128)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('login_ip',64)->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment('0: inactive, 1: actived, 2: deleted (default: 0)');
            $table->string('remember_token',255)->nullable();
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
        Schema::dropIfExists('admins');
    }
}
