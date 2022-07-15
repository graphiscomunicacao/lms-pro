<?php

return [

    'title' => 'Login',

    'heading' => 'Faça login em sua conta',

    'buttons' => [

        'submit' => [
            'label' => 'Login',
        ],

    ],

    'fields' => [

        'email' => [
            'label' => 'E-mail',
        ],

        'password' => [
            'label' => 'Senha',
        ],

        'remember' => [
            'label' => 'Lembrar de mim',
        ],

    ],

    'messages' => [
        'failed' => 'As credenciais não foram encontradas em nossos registros.',
        'throttled' => 'Muitas tentativas de login. Por favor, aguarde :seconds segundos para tentar novamente.',
    ],

];
