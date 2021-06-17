<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page__blocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sort_order')->unsigned()->nullable()->default(0);
            $table->integer('width')->unsigned()->nullable()->default(12);
            $table->longText('options')->nullable();
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('page__pages')->onDelete('cascade');
            // Your fields
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
        Schema::dropIfExists('page__blocks');
    }
}
