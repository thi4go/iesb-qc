<?php

namespace App\Models;

use Cartalyst\Sentinel\Roles\EloquentRole as SentinelRole;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends SentinelRole
{

    use Sluggable;

    protected $fillable = [
        'name',
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
                'source' => 'name',
                'separator' => '.'
            ]
        ];
    }

}
