<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class PageValidator extends LaravelValidator
{

    protected $attributes = [
        'title'             => 'Título',
        'meta_title'        => 'Título da página',
        'meta_description'  => 'Descrição'
    ];

    protected $rules = [
        'title'             => 'required',
        'meta_title'        => 'required',
        'meta_description'  => 'required'
    ];

}
