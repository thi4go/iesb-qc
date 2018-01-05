<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends SentinelUser implements HasMediaConversions
{

  use HasMediaTrait,
      Sluggable;

  protected $fillable = [
    'email',
    'password',
    'last_name',
    'first_name',
    'permissions',
    'avatar',
    'slug'
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
          'source' => 'full_name'
      ]
    ];
  }

  /**
   * Register Media Conversions
   */
  public function registerMediaConversions()
  {
    $this->addMediaConversion('thumb')
      ->setWidth(240)->setHeight(240)->setFit('crop')->setFormat('jpg');
  }

  /**
   * Hidden fields on retrieve data
   */
  protected $hidden = [
    'password',
    'remember_token'
  ];

  /**
   * Return first_name and last_name of user
   */
  public function getFullNameAttribute() {
    return $this->first_name . ' ' . $this->last_name;
  }

  /**
   * Get the linked description (if one is available).
   *
   * @param  mixed    $class
   * @return string
   */
  public function getAvatarAttribute()
  {
    $avatar = $this->getMedia('avatar')->first();
    return isset($avatar) ? $avatar->getUrl('thumb') : '/brzbox/assets/img/avatar.svg';
  }

  public function posts(){
    return $this->hasMany(Post::class);
  }

}
