<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{

    use Sluggable;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'is_active'
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
     * Relate with seo
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

}
