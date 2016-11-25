<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id')->uniqid();
            $table->string('name');
            $table->string('email');
            $table->integer('user_id')->default(0);
            $table->enum('inquiry_type',array_keys(\App\Models\Contact::INQUIRY_TYPE));
            $table->text('contents');
            $table->string('ip');
            $table->string('user_agent');
            $table->tinyInteger('del_flag')->default(0);
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
        Schema::dropIfExists('contacts');
    }
}
