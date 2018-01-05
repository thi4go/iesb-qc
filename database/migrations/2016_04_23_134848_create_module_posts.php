<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('categories', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('color');
        $table->string('slug');
        $table->timestamps();
      });

      Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('slug');
        $table->integer('category_id')->unsigned();
        $table->foreign('category_id')->references('id')->on('categories');
        $table->integer('card_type')->index();
        $table->string('title');
        $table->string('subtitle');
        $table->text('text');
        $table->integer('visits')->default(0)->unsigned();
        $table->boolean('release')->default(0);
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');
        $table->timestamps();
      });

      Schema::create('tags', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('slug');
        $table->timestamps();
      });

      Schema::create('posts_tags', function (Blueprint $table) {
        $table->integer('post_id')->unsigned();
        $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
        $table->integer('tag_id')->unsigned();
        $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('posts_tags');
      Schema::drop('tags');
      Schema::drop('posts');
      Schema::drop('categories');
    }
}
