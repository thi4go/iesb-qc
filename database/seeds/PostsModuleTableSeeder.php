<?php

use Illuminate\Database\Seeder;

class PostsModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(\App\Models\Post::class, 3)->create();
    }
}
