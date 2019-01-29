<?php
 return array (
  'users' => 
  array (
    'description' => 'пользователи',
    'primary_column' => 'id',
    'columns' => 
    array (
      'id' => 
      array (
        'type' => 'int',
        'default' => '{auto_increment}',
        'description' => 'id пользователя',
      ),
      'nickname' => 
      array (
        'description' => 'псевдоним',
        'type' => 
        array (
          'varchar' => 100,
        ),
        'default' => '',
      ),
      'password' => 
      array (
        'description' => 'пароль (md5) для авторизации',
        'type' => 
        array (
          'varchar' => 32,
        ),
        'default' => '',
      ),
      'name' => 
      array (
        'description' => 'имя',
        'type' => 
        array (
          'varchar' => 100,
        ),
        'default' => '',
      ),
      'family_name' => 
      array (
        'description' => 'фамилия',
        'type' => 
        array (
          'varchar' => 100,
        ),
        'default' => '',
      ),
      'email' => 
      array (
        'description' => 'электронная почта',
        'type' => 
        array (
          'varchar' => 100,
        ),
        'default' => '',
      ),
      'is_admin' => 
      array (
        'description' => 'роль администратора',
        'type' => 
        array (
          'enum' => 
          array (
            0 => 'true',
            1 => 'false',
          ),
        ),
        'default' => 'false',
      ),
      'session' => 
      array (
        'description' => 'сессия (md5) авторизации',
        'type' => 
        array (
          'varchar' => 32,
        ),
        'default' => '',
      ),
    ),
    'sortings' => 
    array (
      'is_admin' => 
      array (
        'description' => 'наличие роли администратора',
        'unique' => false,
        'columns' => 
        array (
          0 => 'is_admin',
        ),
      ),
      'nickname' => 
      array (
        'description' => 'псевдонимы',
        'unique' => true,
        'columns' => 
        array (
          0 => 'nickname',
        ),
      ),
      'email' => 
      array (
        'description' => 'электронная почта',
        'unique' => true,
        'columns' => 
        array (
          0 => 'email',
        ),
      ),
    ),
  ),
  'requests_console' => 
  array (
    'description' => 'запросы консоли',
    'primary_column' => 'id',
    'columns' => 
    array (
      'id' => 
      array (
        'type' => 'int',
        'default' => '{auto_increment}',
        'description' => 'id запроса консоли',
      ),
      'date' => 
      array (
        'description' => 'дата',
        'type' => 'datetime',
        'default' => '0000-00-00 00:00:00',
      ),
      'request' => 
      array (
        'description' => 'запрос',
        'type' => 
        array (
          'varchar' => 100,
        ),
        'default' => '',
      ),
      'parameters' => 
      array (
        'description' => 'параметры в json',
        'type' => 'text',
        'default' => '',
      ),
      'status' => 
      array (
        'description' => 'статус обработки запроса',
        'type' => 
        array (
          'enum' => 
          array (
            0 => 'wait',
            1 => 'do',
            2 => 'true',
            3 => 'false',
          ),
        ),
        'default' => 'wait',
      ),
    ),
  ),
); ?>