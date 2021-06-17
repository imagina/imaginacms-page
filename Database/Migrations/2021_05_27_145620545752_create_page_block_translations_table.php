<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageBlockTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page__block_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->text('description');
            $table->integer('block_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['block_id', 'locale']);
            $table->foreign('block_id')->references('id')->on('page__blocks')->onDelete('cascade');
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
        Schema::table('page__block_translations', function (Blueprint $table) {
            $table->dropForeign(['block_id']);
        });
        Schema::dropIfExists('page__block_translations');
    }
}
