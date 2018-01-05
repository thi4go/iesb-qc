<?php

return [

    'app' => [
        'name'  => 'Engenharia Civil',
        'email' => [
            'default' => 'me@hugofabricio.com'
        ]
    ],

    'seo' => [
        'analytics' => 'UA-93334340-1'
    ],

    'modules' => [
        ['name' => 'Acessos', 'path' => 'acessos', 'alias' => 'analytics', 'icon' => 'fa fa-bar-chart'],
        //['name' => 'Mensagens', 'path' => 'mensagens', 'alias' => 'contacts', 'icon' => 'fa fa-envelope'],
        ['name' => 'Posts', 'path' => 'posts', 'alias' => 'posts', 'icon' => 'fa fa-book'],
        ['name' => 'Categorias', 'path' => 'categories', 'alias' => 'categories', 'icon' => 'fa fa-tags'],
        //['name' => 'Páginas', 'path' => 'paginas', 'alias' => 'pages', 'icon' => 'fa fa-file-code-o'],
        ['name' => 'Usuários', 'path' => 'usuarios', 'alias' => 'users', 'icon' => 'fa fa-user'],
        ['name' => 'Grupos', 'path' => 'grupos', 'alias' => 'roles', 'icon' => 'fa fa-users'],
        ['name' => 'Logs', 'path' => 'logs', 'alias' => 'logs', 'icon' => 'fa fa-history'],
    ],

];
