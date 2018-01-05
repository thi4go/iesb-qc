<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [
        'type_id',
        'subject',
        'name',
        'email',
        'phone',
        'message'
    ];

    /**
     * Remove phone mask
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = trim(preg_replace('#[^0-9]#', '', $value));
    }

}
