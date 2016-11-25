<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('advertiser_id');
            $table->integer('banner_id')->nullable()->default(0);
            $table->integer('promotion_id');
            $table->string('advertiser_name');
            $table->string('promotion_name');
            $table->integer('category_id');
            $table->text('detail_media', 5000);
            $table->text('detail_enduser', 5000);
            $table->text('certificate_condition', 5000);
            $table->text('condition_reward', 5000);
            $table->string('image_filename', 255);
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->tinyInteger('delete_flag')->nullable()->default(0)->comment('0: active, 1: delete (default: 0)');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unique(['advertiser_id', 'promotion_id']);
            $table->index('advertiser_id');
            $table->index('promotion_id');
            $table->index('banner_id');
        });
        DB::statement('ALTER TABLE campaigns ADD FULLTEXT full(advertiser_name, promotion_name, detail_enduser)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
