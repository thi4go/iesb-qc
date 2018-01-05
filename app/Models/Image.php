<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Image extends Model implements HasMediaConversions
{

  use HasMediaTrait;

  protected $fillable = [
    'user_id'
  ];

  /**
   * Register Media Conversions
   */
  public function registerMediaConversions()
  {
    $this->addMediaConversion('thumbs')
        ->setWidth(180)->setHeight(180)->setFit('crop')->setFormat('jpg');
    $this->addMediaConversion('cover')
        ->setWidth(740)->setHeight(480)->setFit('contain')->setFormat('jpg');
  }

  public function getFileAttribute()
  {
    $image = $this->getMedia()->first();
    return isset($image) ? $image : null;
  }

  public function user()
  {
    return $this->belongsTo(User::class)->select('id', 'first_name', 'last_name');
  }

}
