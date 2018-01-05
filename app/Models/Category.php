<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{

  use Sluggable;

  protected $fillable = [
    'name',
    'color',
  ];

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
          'source' => 'name'
      ]
    ];
  }

  public function posts(){
    return $this->hasMany(Post::class);
  }

  /**
   * Relate with seo
   */
  public function seo()
  {
    return $this->morphOne(Seo::class, 'seoable');
  }
}
