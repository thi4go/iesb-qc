<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('ratings', function (Blueprint $table) {
        $table->increments('id');
        $table->ipAddress('visitor');
        $table->integer('rating');
        $table->morphs('rateable');
        $table->unsignedInteger('user_id')->nullable();
        $table->index('rateable_id');
        $table->index('rateable_type');
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
      Schema::drop('ratings');
    }
}
