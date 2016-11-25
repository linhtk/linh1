<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->string('category_vn')->comment('Tieng Viet');
            $table->string('category_en')->comment('Tieng Anh');
            $table->integer('order');
            $table->tinyInteger('status')->default(0)->comment('0: inactive, 1: actived, 2: deleted (default: 0)');
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
        Schema::drop('categories');
    }
}
