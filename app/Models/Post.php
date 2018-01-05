<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use willvincent\Rateable\Rateable;

class Post extends Model implements HasMediaConversions
{

  use HasMediaTrait,
      Sluggable,
      Rateable;

  protected $fillable = [
    'title',
    'subtitle',
    'text',
    'user_id',
    'category_id',
    'card_type',
    'visits',
    'release',
    'slug',
    'user_id'
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
          'source' => 'title'
      ]
    ];
  }

  /**
   * Register Media Conversions
   */
  public function registerMediaConversions()
  {
    $this->addMediaConversion('thumbs')
        ->setWidth(640)->setFit('crop')->setFormat('jpg');
    $this->addMediaConversion('cover')
        ->setWidth(1920)->setHeight(1080)->setFit('contain')->setFormat('jpg');
    //$this->addMediaConversion('mobile')
        //->setWidth(1920)->setHeight(1080)->setFit('contain')->setFormat('jpg');
  }

  /**
   * Getters
   */
  public function getTagListAttribute() {
    $tags = $this->tags()->pluck('name')->all();
    return implode(', ', $tags);
  }

  public function getImageAttribute()
  {
    $image = $this->getMedia()->first();
    return isset($image) ? $image : null;
  }

  /**
  * Relationships
  */
  public function user()
  {
    return $this->belongsTo(User::class)->select('id', 'first_name', 'last_name', 'slug');
  }

  public function category()
  {
    return $this->belongsTo(Category::class)->select('id', 'name', 'slug', 'color');
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'posts_tags')->select('id', 'name', 'slug');
  }

  public function seo()
  {
    return $this->morphOne(Seo::class, 'seoable');
  }

}
