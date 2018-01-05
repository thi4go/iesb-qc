<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{

  protected $table = 'seo';

  protected $fillable = [
    'seoable_type',
    'seoable_id',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'og_image'
  ];

  /**
   * Setters
   */
  public function setMetaKeywordsAttribute($value)
  {
    if(empty($value)):
      $this->attributes['meta_keywords'] = null;
    else:
      $this->attributes['meta_keywords'] = implode(', ', array_map('trim', explode(',', $value)));
    endif;
  }

  /**
   * Polymorphism function
   * @return type
   */
  public function seoable()
  {
    return $this->morphTo();
  }

}
