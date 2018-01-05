<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{

    use Sluggable;

    protected $fillable = [
        'name',
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
        return $this->belongsToMany(Post::class, 'posts_tags');
    }

}
