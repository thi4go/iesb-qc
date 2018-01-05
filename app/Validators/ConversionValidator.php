<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class ConversionValidator extends LaravelValidator
{

    protected $attributes = [
        'name'              => 'Nome',
        'email'             => 'E-mail'
    ];

    protected $rules = [
        'name'              => 'required',
        'email'             => 'required|email'
    ];

}
