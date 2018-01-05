<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class CategoryValidator extends LaravelValidator
{

    protected $attributes = [
        'name' => 'Nome',
        'color' => 'Cor',
    ];

    protected $rules = [
        'name' => 'required|unique:categories',
        'color' => 'required',
    ];

}
