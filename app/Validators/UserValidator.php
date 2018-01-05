<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{

    protected $attributes = [
        'first_name'                => 'Nome',
        'last_name'                 => 'Sobrenome',
        'email'                     => 'E-mail',
        'password'                  => 'Senha',
        'password_confirmation'     => 'Confirmar senha',
        'avatar'                    => 'Foto de perfil',
        'roles'                     => 'Permissões',
    ];

    protected $rules = [
        'auth' => [
            'email'                 => 'required|email',
            'password'              => 'required'
        ],
        'reminder_start' => [
            'email'                 => 'required|email'
        ],
        'reminder_end' => [
            'password'              => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password'
        ],
        'profile' => [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'password'              => 'min:8',
            'password_confirmation' => 'required_with:password|same:password',
            'avatar'                => 'image|max:5000'
        ],
        'user_create' => [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password',
            'roles'                 => 'required'
        ],
        'user_edit' => [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users',
            'roles'                 => 'required'
        ]
    ];

}
