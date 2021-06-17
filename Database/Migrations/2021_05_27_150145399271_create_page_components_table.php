<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page__components', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('module');
            $table->string('name');
            $table->integer('sort_order')->unsigned()->nullable()->default(0);
            $table->integer('width')->unsigned()->nullable()->default(12);
            $table->longText('options')->nullable();
            $table->integer('block_id')->unsigned()->nullable();
            $table->foreign('block_id')->references('id')->on('page__blocks')->onDelete('cascade');
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
        Schema::table('page__components', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
        });

        Schema::dropIfExists('page__components');
    }
}
