<?php

return array(

    'index'    => [
        'goals' => array(

             /*цель*/
            'index' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Framework life balance',
                'Описание страницы'    => 'Framework life balance это единый порядок разработки веб-сайта на php и js (html,css,image).',
                'Ключевики страницы'   => 'framework, php, среда разработки',
            ],
             /*цель*/
            'error' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Ошибка',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
            /*цель*/
            'stop' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Ограничение доступа',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
            /*цель*/
            'engineering_works' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Техническая работа',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'send_error' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Обратная связь',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'site_map' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Карта сайта',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
            /*цель*/
            'site_map_xml' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
        )
    ],
    'users'    => [
        'goals' => array(

             /*цель*/
            'index' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Список пользователей',
                'Описание страницы'    => 'Пользователи',
                'Ключевики страницы'   => 'Пользователи',
            ],
             /*цель*/
            'registration' => [
                /*предназначение*/
                'intended' => 'unauthorized',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Регистрация',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'registration_ok' => [
                /*предназначение*/
                'intended' => 'unauthorized',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Вы зарегистрированы!',
                'Описание страницы'    => 'Вы зарегистрированы на проекте Framework life balance',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'authorize' => [
                /*предназначение*/
                'intended' => 'unauthorized',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Авторизация',
                'Описание страницы'    => 'Авторизация на проекте Framework life balance',
                'Ключевики страницы'   => 'Авторизация',
            ],
            /*цель*/
            'authorized_ok' => [
                /*предназначение*/
                'intended' => 'authorized',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Вы авторизованы!',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
            /*цель*/
            'authorized_data' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => '',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'unauthorize' => [
                /*предназначение*/
                'intended' => 'authorized',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => false,
                'Заголовок страницы'   => '',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'unauthorized_ok' => [
                /*предназначение*/
                'intended' => 'unauthorized',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Вы не авторизованы',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
             /*цель*/
            'check_nickname_registration' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
            /*цель*/
            'check_nickname_no_registration' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
             /*цель*/
            'check_password_valid_by_nickname' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
             /*цель*/
            'check_email_no_registration' => [
                /*предназначение*/
                'intended' => 'any',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
        )
    ],
    'control'  => [

        'goals' => array(

            /*цель*/
            'index' => [
                /*предназначение*/
                'intended' => 'authorized_by_administrator',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Контрольная панель',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
            /*цель*/
            'errors' => [
                /*предназначение*/
                'intended' => 'authorized_by_administrator',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'array',
                'Заголовок страницы'   => 'Претензии в ядре',
                'Описание страницы'    => '',
                'Ключевики страницы'   => '',
            ],
            /*цель*/
            'reassembly_data_base' => [
                /*предназначение*/
                'intended' => 'console',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 3600,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
            /*цель*/
            'send_email' => [
                /*предназначение*/
                'intended' => 'console',
                /*оптимальное время выполнения в сек.*/
                'lead_time' => 1,
                /*формат выдачи результата*/
                'format_result' => 'text',
            ],
        )
    ],

);


?>
