<?php

namespace Framework_life_balance\core_components\experiences;

use \Framework_life_balance\core_components\Space;
use \Framework_life_balance\core_components\Conditions;
use \Framework_life_balance\core_components\Distribution;
use \Framework_life_balance\core_components\Realization;

class Category_users
{

    static function index($parameters)
    {

        /* Получаем всех пользователей */
        $users = Distribution::interchange_information_with_data_base([
            'Направление' => 'Получение',
            'Чего'        => 'Всех пользователей',
            'Значение'    => [],
        ]);

        /*убираем приватные данные*/
        if($users){
            foreach($users as $num=>$user){
                unset($users[$num]['password']);
                unset($users[$num]['email']);
                unset($users[$num]['session']);
            }
        }

        return [
            'users' => $users,
        ];

    }

    static function registration($parameters)
    {
        $nickname = '';
        $name = '';
        $family_name = '';
        $email = '';
        $password = '';

        $registration_error = '';

        if(isset($parameters['nickname_registration']) and isset($parameters['name']) and isset($parameters['family_name']) and isset($parameters['email']) and isset($parameters['password_registration'])){

            $nickname = htmlspecialchars($parameters['nickname_registration']);
            $name = htmlspecialchars($parameters['name']);
            $family_name = htmlspecialchars($parameters['family_name']);
            $email = htmlspecialchars($parameters['email']);
            $password = htmlspecialchars($parameters['password_registration']);

            if(strlen($nickname)<1 or strlen($nickname)>100){
                $registration_error = 'У псевдонима допустима длинна от 1 до 100 символов!';
            }
            elseif(strlen($name)<1 or strlen($name)>100){
                $registration_error = 'У имени допустима длинна от 1 до 100 символов!';
            }
            elseif(!preg_match('/^[а-яА-Я]+$/msiu',trim($name),$preg_row)){
                $registration_error = 'У имени допустимы только русские буквы!';
            }
            elseif(strlen($family_name)<1 or strlen($family_name)>100){
                $registration_error = 'У фамилии допустима длинна от 1 до 100 символов!';
            }
            elseif(!preg_match('/^[а-яА-Я]+$/msiu',$family_name)){
                $registration_error = 'У фамилии допустимы только русские буквы!';
            }
            elseif(strlen($email)<1 or strlen($email)>100){
                $registration_error = 'У электронного адреса допустима длинна от 1 до 100 символов!';
            }
            elseif(!preg_match ('/^[а-яА-ЯёЁa-zA-Z0-9_\-\.]+@[а-яА-ЯёЁa-zA-Z0-9_\-\.]+\.[а-яА-ЯёЁa-zA-Z0-9_\-]/u', $email)){
                $registration_error = 'У электронного адреса не верный формат!';

            }
            elseif(strlen($password)<5){
                $registration_error = 'У пароля допустима длинна от 5 символов!';
            }
            /*проверка псевдонима на не зарегистрированность*/
            elseif(self::check_nickname_no_registration(['nickname' => $nickname])=='false'){
                $registration_error = 'Псевдоним уже ранее зарегистрирован!';
            }
            elseif(self::check_email_no_registration(['email' => $email])=='false'){
                $registration_error = 'Электронная почта уже ранее зарегистрирована!';
            }
            else{

                /*форминование пароля пользователя*/
                $password_formation = Conditions::formation_user_password([
                    'Пароль пользователя' => $password,
                ]);

                /* Добавляем пользователя */
                $user_id = Distribution::interchange_information_with_data_base([
                    'Направление' => 'Добавление',
                    'Чего'        => 'Нового пользователя',
                    'Значение'    => [
                        ':nickname'    => $nickname,
                        ':password'    => $password_formation,
                        ':name'        => $name,
                        ':family_name' => $family_name,
                        ':email'       => $email
                    ],
                ]);

                /* Получаем количество всех пользователей */
                $users_count = Distribution::interchange_information_with_data_base([
                    'Направление' => 'Количество',
                    'Чего'        => 'Всех пользователей',
                    'Значение'    => [],
                ]);

                /*присваиваем административные права первому пользователю*/
                if($users_count == 1){

                    /* Ставит/отменяет назначение администратором */
                    Distribution::interchange_information_with_data_base([
                        'Направление' => 'Изменение',
                        'Чего'        => 'Роли администрирования у пользователя',
                        'Значение'    => [
                            ':id'       => $user_id,
                            ':is_admin' => 'true',
                        ],
                    ]);

                }

                /*вызываем консоль наработку отправления на почту*/
                Realization::call_console_experience([
                    'Наработка'         => 'control',
                    'Наработанная цель' => 'send_email',
                    'Параметры'         => [
                        'email'    => $email,
                        'title'    => 'Ваша регистрация на '.$_SERVER['SERVER_NAME'],
                        'text'     => 'Вы успешно зарегистрированы!<br>Ваш псевдоним: <b style="color:green;">'.$nickname.'</b><br>Ваш пароль: <b style="color:green;">'.$password.'</b>',
                        'template' => 'Элементы тэгов mail'.DIRECTORY_SEPARATOR.'message',
                    ],
                ]);

                /*Вызываем выполнение подтверждения регистрации*/
                return Realization::call_experience([
                    'Наработка'         => 'users',
                    'Наработанная цель' => 'registration_ok',
                    'Параметры'         => [
                        'nickname' => $nickname,
                        'password' => $password
                    ],
                ]);

            }

        }

        return [
            'nickname' => $nickname,
            'name' => $name,
            'family_name' => $family_name,
            'password' => $password,
            'email' => $email,
            'registration_error' => $registration_error,
        ];
    }

    static function registration_ok($parameters)
    {

        if(isset($parameters['nickname'])){
            $nickname = htmlspecialchars($parameters['nickname']);
        }
        else{
            $nickname = '';
        }

        if(isset($parameters['password'])){
            $password = htmlspecialchars($parameters['password']);
        }
        else{
            $password = '';
        }

        return [
            'nickname' => $nickname,
            'password' => $password
        ];
    }

    static function authorize($parameters)
    {
        $nickname = '';
        $password = '';

        $authorize_error = '';

        if(isset($parameters['nickname_authorize']) and isset($parameters['password_authorize'])){

            $nickname = htmlspecialchars($parameters['nickname_authorize']);
            $password = htmlspecialchars($parameters['password_authorize']);

            /*проверка псевдонима на зарегистрированность*/
            if(self::check_nickname_registration(['nickname' => $nickname])=='false'){
                $authorize_error = 'Псевдоним не зарегистрирован!';
            }
            /*проверка правильного пароля по псеводиму*/
            elseif(self::check_password_valid_by_nickname(['nickname' => $nickname, 'password' => $password])=='false'){
                $authorize_error = 'Не верный пароль!';
            }
            else{

                /*форминование пароля пользователя*/
                $password_formation = Conditions::formation_user_password([
                    'Пароль пользователя' => $password,
                ]);

                /* Получаем id пользователя по псевдониму и паролю */
                $user_id = Distribution::interchange_information_with_data_base([
                    'Направление' => 'Получение',
                    'Чего'        => 'Id пользователя по авторизационым данным',
                    'Значение'    => [
                        ':nickname' => $nickname,
                        ':password' => $password_formation,
                    ],
                ]);

                /*обновление у пользователя сессии авторизации*/
                $user_session = Conditions::formation_user_session([
                    'Идентификатор пользователя' => $user_id,
                ]);

                /* Обновление пользователю сессии авторизации */
                Distribution::interchange_information_with_data_base([
                    'Направление' => 'Изменение',
                    'Чего'        => 'Сессии у пользователя',
                    'Значение'    => [
                        ':id'      => $user_id,
                        ':session' => $user_session,
                    ],
                ]);

                /*Вызываем выполнение удачной авторизации*/
                return Realization::call_experience([
                    'Наработка'         => 'users',
                    'Наработанная цель' => 'authorized_ok',
                    'Параметры'         => [
                        'user_id'      => $user_id,
                        'user_session' => $user_session
                    ],
                ]);

            }

        }

        return [
            'nickname'        => $nickname,
            'password'        => $password,
            'authorize_error' => $authorize_error
        ];

    }

    static function authorized_ok($parameters)
    {

        return [
            'user_id'      => $parameters['user_id'],
            'user_session' => $parameters['user_session']
        ];

    }

    static function authorized_data($parameters)
    {
        return [
            'user_data' => Realization::data_authorized_user([
                'Показать определенную часть данных' => null,
            ])
        ];

    }

    static function unauthorize($parameters)
    {
        /*получаем значение индификационного номера пользователя*/
        $user_id = Space::get_mission([
            'Ключ' => 'user_id',
        ]);

        /* Сбрасываем память о пользователе */
        Realization::work_with_memory_data([
            'Обозначение ячейки памяти' => 'session_'.$user_id,
            'Значение для записи'       => false,
            'Время хранения в сек.'     => false,
            'Очистка ячейки'            => true,
        ]);

        /*Вызываем выполнение удачного сброса авторизации*/
        return Realization::call_experience([
            'Наработка'         => 'users',
            'Наработанная цель' => 'unauthorized_ok',
            'Параметры'         => [],
        ]);

    }

    static function unauthorized_ok($parameters)
    {
        return [
        ];

    }

    static function check_nickname_registration($parameters)
    {

        $is_nickname_registration = 'false';

        /*проверяем занятости имени*/
        if(isset($parameters['nickname'])){

            $nickname = htmlspecialchars($parameters['nickname']);

            if(Distribution::interchange_information_with_data_base([
                'Направление' => 'Получение',
                'Чего'        => 'Id пользователя по псевдониму',
                'Значение'    => [
                    ':nickname' => $nickname,
                ],
            ])){
                $is_nickname_registration='true';
            }
        }

        return $is_nickname_registration;

    }

    static function check_nickname_no_registration($parameters)
    {

        $is_nickname_no_registration = 'false';

        if(isset($parameters['nickname'])){

            /*проверка занятости имени*/
            $is_nickname_registration = self::check_nickname_registration(['nickname' => $parameters['nickname']]);

            $is_nickname_no_registration = $is_nickname_registration=='true'?'false':'true';
        }

        return $is_nickname_no_registration;

    }

    static function check_password_valid_by_nickname($parameters)
    {

        $is_password_valid = 'false';

       if(isset($parameters['nickname']) and isset($parameters['password'])){

           /*форминование пароля пользователя*/
           $password_formation = Conditions::formation_user_password([
               'Пароль пользователя' => $parameters['password'],
           ]);

           /* Получаем id пользователя по псевдониму и паролю */
           $user_id = Distribution::interchange_information_with_data_base([
               'Направление' => 'Получение',
               'Чего'        => 'Id пользователя по авторизационым данным',
               'Значение'    => [
                   ':nickname' => $parameters['nickname'],
                   ':password' => $password_formation,
               ],
           ]);

           if($user_id){
               $is_password_valid = 'true';
           }
           else{
               $is_password_valid = 'false';
           }

       }

        return $is_password_valid;

    }

    static function check_email_no_registration($parameters)
    {


        $is_email_no_registration = 'false';

        /*проверяем наличие емейла в базе*/
        if(isset($parameters['email'])){

            $email = htmlspecialchars($parameters['email']);

            if(!Distribution::interchange_information_with_data_base([
                'Направление' => 'Получение',
                'Чего'        => 'Id пользователя по электронному адресу',
                'Значение'    => [
                    ':email' => $email,
                ],
            ])){
                $is_email_no_registration='true';
            }
        }

        return $is_email_no_registration;

    }
    
}
