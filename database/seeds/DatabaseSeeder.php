<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();

      $this->call(UsersModuleTableSeeder::class);
      $this->call(CategoriesModuleTableSeeder::class);
      $this->call(PostsModuleTableSeeder::class);
      $this->call(SeoModuleTableSeeder::class);

      Model::reguard();
    }
}
