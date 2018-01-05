<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class PostValidator extends LaravelValidator
{

    protected $attributes = [
      'title'             => 'Título',
      'subtitle'          => 'Subtítulo',
      'text'              => 'Texto',
      'category_id'       => 'Categoria',
      'image'             => 'Capa',
      'meta_title'        => 'Título da página',
      'meta_description'  => 'Descrição'
    ];

    protected $rules = [
      'title'             => 'required',
      'subtitle'          => 'required',
      'text'              => 'required',
      'category_id'       => 'required',
      'image'             => 'image|max:5000',
      'meta_title'        => 'required',
      'meta_description'  => 'required'
    ];

}
