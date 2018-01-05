<?php

use Illuminate\Database\Seeder;

class SeoModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $posts = [];
      for ($i=1; $i <= 3; $i++) {
        $posts[] = [
          'seoable_id' => $i,
          'seoable_type' => 'App\Models\Post',
          'meta_title' => 'Título do post ' . $i,
          'meta_description' => 'Descrição do post.',
          'meta_keywords' => 'key1, key2, key3',
          'created_at' => new DateTime,
          'updated_at' => new DateTime
        ];
      }

      $categories = [];
      for ($i=1; $i <= 5; $i++) {
        $categories[] = [
          'seoable_id' => $i,
          'seoable_type' => 'App\Models\Category',
          'meta_title' => 'Categoria ' . $i,
          'meta_description' => 'Descrição da categoria.',
          'meta_keywords' => 'key1, key2, key3',
          'created_at' => new DateTime,
          'updated_at' => new DateTime
        ];
      }

      // Create seo
      DB::table('seo')->truncate();
      DB::table('seo')->insert($posts);
      DB::table('seo')->insert($categories);
    }
}
