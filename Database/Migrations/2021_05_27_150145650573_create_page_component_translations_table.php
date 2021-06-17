<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageComponentTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page__component_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->longText('params')->nullable();
            $table->integer('component_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['component_id', 'locale']);
            $table->foreign('component_id')->references('id')->on('page__components')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page__component_translations', function (Blueprint $table) {
            $table->dropForeign(['component_id']);
        });
        Schema::dropIfExists('page__component_translations');
    }
}
