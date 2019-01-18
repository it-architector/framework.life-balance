<?php

namespace Framework_life_balance\core_components\experiences;

use \Framework_life_balance\core_components\Notices;
use \Framework_life_balance\core_components\Solutions;
use \Framework_life_balance\core_components\Resources;
use \Framework_life_balance\core_components\Business;

class Users
{

    function index(array $parameters)
    {

        /* Получаем всех пользователей */
        $users = Resources::interchange_information_with_data_base('Получение', 'Всех пользователей', []);

        /*убираем приватные данные*/
        if($users){
            foreach($users as $num=>$user){
                unset($users[$num]['password']);
                unset($users[$num]['email']);
                unset($users[$num]['session']);
            }
        }

        return [
            'title' => 'Пользователи',
            'description' => 'Пользователи',
            'keywords' => 'Пользователи',
            'content' => [
                'users' => $users,
            ]
        ];

    }

    function registration(array $parameters)
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
            elseif($this->check_nickname_no_registration($parameters,$nickname)=='false'){
                $registration_error = 'Псевдоним уже ранее зарегистрирован!';
            }
            elseif($this->check_email_no_registration($parameters,$email)=='false'){
                $registration_error = 'Электронная почта уже ранее зарегистрирована!';
            }
            else{

                /*форминование пароля пользователя*/
                $password_formation = Solutions::formation_user_password($password);

                /* Добавляем пользователя */
                $user_id = Resources::interchange_information_with_data_base('Добавление', 'Нового пользователя', [
                    ':nickname'    => $nickname,
                    ':password'    => $password_formation,
                    ':name'        => $name,
                    ':family_name' => $family_name,
                    ':email'       => $email
                ]);

                /* Получаем количество всех пользователей */
                $users_count = Resources::interchange_information_with_data_base('Количество', 'Всех пользователей', []);

                /*присваиваем административные права первому пользователю*/
                if($users_count == 1){

                    /* Ставит/отменяет назначение администратором */
                    Resources::interchange_information_with_data_base('Изменение', 'Роли администрирования у пользователя', [
                        ':id'       => $user_id,
                        ':is_admin' => 'true',
                    ]);

                }

                /*вызываем консоль наработку отправления на почту*/
                Business::call_console_experience('control', 'send_email', [
                    'email'    => $email,
                    'title'    => 'Ваша регистрация на '.$_SERVER['SERVER_NAME'],
                    'text'     => 'Вы успешно зарегистрированы!<br>Ваш псевдоним: <b style="color:green;">'.$nickname.'</b><br>Ваш пароль: <b style="color:green;">'.$password.'</b>',
                    'template' => 'mail'.DIRECTORY_SEPARATOR.'message',
                ]);

                /*Вызываем выполнение подтверждения регистрации*/
                return Business::call_experience('users','registration_ok',['nickname' => $nickname, 'password' => $password]);

            }

        }

        return [
            'title' => 'Регистрация',
            'description' => 'Регистрация на проекте',
            'keywords' => 'регистрация',
            'content' => [
                'nickname' => $nickname,
                'name' => $name,
                'family_name' => $family_name,
                'password' => $password,
                'email' => $email,
                'registration_error' => $registration_error,
            ]
        ];
    }

    function registration_ok(array $parameters)
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
            'title' => 'Вы зарегистрированы!',
            'description' => 'Вы зарегистрированы на проекте',
            'keywords' => 'регистрация',
            'content' => [
                'nickname' => $nickname,
                'password' => $password
            ]
        ];
    }

    function authorize(array $parameters)
    {
        $nickname = '';
        $password = '';

        $authorize_error = '';

        if(isset($parameters['nickname_authorize']) and isset($parameters['password_authorize'])){

            $nickname = htmlspecialchars($parameters['nickname_authorize']);
            $password = htmlspecialchars($parameters['password_authorize']);

            /*проверка псевдонима на зарегистрированность*/
            if($this->check_nickname_registration($parameters,$nickname)=='false'){
                $authorize_error = 'Псевдоним не зарегистрирован!';
            }
            /*проверка правильного пароля по псеводиму*/
            elseif($this->check_password_valid_by_nickname($parameters,$password, $nickname)=='false'){
                $authorize_error = 'Не верный пароль!';
            }
            else{

                /*форминование пароля пользователя*/
                $password_formation = Solutions::formation_user_password($password);

                /* Получаем id пользователя по псевдониму и паролю */
                $user_id = Resources::interchange_information_with_data_base('Получение', 'Id пользователя по авторизационым данным', [
                    ':nickname' => $nickname,
                    ':password' => $password_formation,
                ]);

                /*обновление у пользователя сессии авторизации*/
                $user_session = Solutions::formation_user_session($user_id);

                /* Обновление пользователю сессии авторизации */
                Resources::interchange_information_with_data_base('Изменение', 'Сессии у пользователя', [
                    ':id'      => $user_id,
                    ':session' => $user_session,
                ]);

                /*Вызываем выполнение удачной авторизации*/
                return Business::call_experience('users','authorized_ok',[
                    'user_id'      => $user_id,
                    'user_session' => $user_session
                ]);

            }

        }

        return [
            'title' => 'Авторизация',
            'description' => '',
            'keywords' => '',
            'content' => [
                'nickname'        => $nickname,
                'password'        => $password,
                'authorize_error' => $authorize_error
            ]
        ];

    }

    function unauthorize(array $parameters)
    {

        /*Вызываем выполнение удачного сброса авторизации*/
        return Business::call_experience('users','unauthorized_ok',[]);

    }

    function authorized_data(array $parameters)
    {
        return [
            'title' => 'Вы авторизованы',
            'description' => '',
            'keywords' => '',
            'content' => [
                'user_data' => Business::data_authorized_user()
            ]
        ];

    }

    function authorized_ok(array $parameters)
    {

        return [
            'title' => 'Вы авторизованы',
            'description' => '',
            'keywords' => '',
            'content' => [
                'user_id'      => $parameters['user_id'],
                'user_session' => $parameters['user_session']
            ]
        ];

    }

    function unauthorized_ok(array $parameters)
    {
        return [
            'title' => 'Вы не авторизованы',
            'description' => '',
            'keywords' => '',
            'content' => [
            ]
        ];

    }

    function check_nickname_registration(array $parameters, $nickname=null)
    {

        if($nickname==null){
            if(isset($parameters['nickname'])){
                $nickname=$parameters['nickname'];
            }
        }

        $is_nickname_registration = 'false';

        /*проверяем занятости имени*/
        if($nickname){

            $nickname = htmlspecialchars($nickname);

            if(Resources::interchange_information_with_data_base('Получение', 'Id пользователя по псевдониму', [':nickname' => $nickname])){
                $is_nickname_registration='true';
            }
        }

        return $is_nickname_registration;

    }

    function check_nickname_no_registration(array $parameters, $nickname=null)
    {

        if($nickname==null){
            if(isset($parameters['nickname'])){
                $nickname=$parameters['nickname'];
            }
        }

        /*проверка занятости имени*/
        $is_nickname_registration = $this->check_nickname_registration($parameters,$nickname);

        $is_nickname_no_registration = $is_nickname_registration=='true'?'false':'true';

        return $is_nickname_no_registration;

    }

    function check_email_no_registration(array $parameters, $email=null)
    {

        if($email==null){
            if(isset($parameters['email'])){
                $email=$parameters['email'];
            }
        }


        $is_email_no_registration = 'false';

        /*проверяем наличие емейла в базе*/
        if($email!=null){

            $email = htmlspecialchars($email);

            if(!Resources::interchange_information_with_data_base('Получение', 'Id пользователя по электронному адресу', [':email' => $email])){
                $is_email_no_registration='true';
            }
        }

        return $is_email_no_registration;

    }

    function check_password_valid_by_nickname(array $parameters, $password=null, $nickname=null)
    {

        if($nickname==null){
            if(isset($parameters['nickname'])){
                $nickname=$parameters['nickname'];
            }
        }

        if($password==null){
            if(isset($parameters['password'])){
                $password=$parameters['password'];
            }
        }

        /*форминование пароля пользователя*/
        $password_formation = Solutions::formation_user_password($password);

        /* Получаем id пользователя по псевдониму и паролю */
        $user_id = Resources::interchange_information_with_data_base('Получение', 'Id пользователя по авторизационым данным', [
            ':nickname' => $nickname,
            ':password' => $password_formation,
        ]);

        if($user_id){
            $is_password_valid = 'true';
        }
        else{
            $is_password_valid = 'false';
        }

        return $is_password_valid;

    }
}
