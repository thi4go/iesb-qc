<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class ContactValidator extends LaravelValidator
{

    protected $attributes = [
        'subject'           => 'Assunto',
        'name'              => 'Nome',
        'email'             => 'E-mail',
        'phone'             => 'Telefone',
        'message'           => 'Mensagem'
    ];

    protected $rules = [
        'subject'           => 'required',
        'name'              => 'required',
        'email'             => 'required|email',
        'phone'             => 'required',
        'message'           => 'required'
    ];

}
