<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class RoleValidator extends LaravelValidator
{

    protected $attributes = [
        'name'          => 'Nome'
    ];

    protected $rules = [
        'name'          => 'required|unique:roles'
    ];

}
