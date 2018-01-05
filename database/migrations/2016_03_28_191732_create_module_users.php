<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->string('code');
          $table->boolean('completed')->default(0);
          $table->timestamp('completed_at')->nullable();
          $table->timestamps();
        });

        Schema::create('persistences', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->string('code')->unique();;
          $table->timestamps();
        });

        Schema::create('reminders', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->string('code');
          $table->boolean('completed')->default(0);
          $table->timestamp('completed_at')->nullable();
          $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug')->unique();
          $table->string('name')->unique();
          $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug')->unique();
          $table->string('name');
          $table->text('permissions')->nullable();
          $table->timestamps();
        });

        Schema::create('role_users', function (Blueprint $table) {
          $table->integer('user_id')->unsigned();
          $table->integer('role_id')->unsigned();
          $table->nullableTimestamps();
          $table->primary(['user_id', 'role_id']);
        });

        Schema::create('throttle', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->nullable();
          $table->string('type');
          $table->string('ip')->nullable();
          $table->timestamps();
          $table->index('user_id');
        });

        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('email')->unique();
          $table->string('password');
          $table->text('permissions')->nullable();
          $table->timestamp('last_login')->nullable();
          $table->string('first_name')->nullable();
          $table->string('last_name')->nullable();
          $table->string('slug')->nullable();
          $table->timestamps();
        });

        Schema::create('activity_log', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
          $table->integer('content_id')->nullable();
          $table->string('content_type', 72)->nullable();
          $table->string('action', 32)->nullable();
          $table->string('description')->nullable();
          $table->text('details')->nullable();
          $table->boolean('developer');
          $table->string('ip_address', 64);
          $table->string('user_agent');
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
      Schema::drop('activity_log');
      Schema::drop('users');
      Schema::drop('throttle');
      Schema::drop('role_users');
      Schema::drop('roles');
      Schema::drop('permissions');
      Schema::drop('reminders');
      Schema::drop('persistences');
      Schema::drop('activations');
    }
}
