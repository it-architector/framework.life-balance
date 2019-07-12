<?php

return array(

    /*таблица*/
    'users'             => [

        /*предназначение таблицы*/
        'description' => 'пользователи',

        /*первичная колонка*/
        'primary_column' => 'id',

        /*колонки*/
        'columns' => array(
            'id' => [
                'description' => 'id пользователя',
                'type'        => 'int',
                'default'     => '{auto_increment}'
            ],
            'nickname' => [
                'description' => 'псевдоним',
                'type'        => ['varchar' => 100],
                'default'     => ''
            ],
            'password' => [
                'description' => 'пароль (md5) для авторизации',
                'type'        => ['varchar' => 32],
                'default'     => ''
            ],
            'name' => [
                'description' => 'имя',
                'type'        => ['varchar' => 100],
                'default'     => ''
            ],
            'family_name' => [
                'description' => 'фамилия',
                'type'        => ['varchar' => 100],
                'default'     => ''
            ],
            'email' => [
                'description' => 'электронная почта',
                'type'        => ['varchar' => 100],
                'default'     => ''
            ],
            'is_admin' => [
                'description' => 'роль администратора',
                'type'        => ['enum' => ['true','false']],
                'default'     => 'false'
            ],
            'session' => [
                'description' => 'сессия (md5) авторизации',
                'type'        => ['varchar' => 32],
                'default'     => ''
            ],
        ),

        /*сортировки*/
        'sortings' => [
            'is_admin' =>[
                'description' => 'наличие роли администратора',
                'unique'   => false,
                'columns'  => ['is_admin']
            ],
            'nickname' =>[
                'description' => 'псевдонимы',
                'unique'   => true,
                'columns'  => ['nickname']
            ],
            'email' =>[
                'description' => 'электронная почта',
                'unique'   => true,
                'columns'  => ['email']
            ],
        ],

        /*связи*/
        'references' => [

        ],

    ],

    /*таблица*/
    'requests_console'  => [

        /*предназначение таблицы*/
        'description' => 'запросы консоли',

        /*первичная колонка*/
        'primary_column' => 'id',

        /*колонки*/
        'columns' => array(
            'id' => [
                'description' => 'id запроса консоли',
                'type'        => 'int',
                'default'     => '{auto_increment}'
            ],
            'date' => [
                'description' => 'дата',
                'type'        => 'datetime',
                'default'     => '0000-00-00 00:00:00'
            ],
            'request' => [
                'description' => 'запрос',
                'type'        => ['varchar' => 100],
                'default'     => ''
            ],
            'parameters' => [
                'description' => 'параметры в json',
                'type'        => 'text',
                'default'     => ''
            ],
            'status' => [
                'description' => 'статус обработки запроса',
                'type'        => ['enum' => ['wait', 'do', 'true', 'false']],
                'default'     => 'wait'
            ],
        ),

        /*сортировки*/
        'sortings' => [

        ],

        /*связи*/
        'references' => [

        ],
    ],

);

?>
