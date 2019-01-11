<?php

namespace Framework_life_balance\core_components\experiences;

interface Structure_Users
{
    /*Главная страницы с пользователями*/
    function index(array $parameters);

    /*Регистрация*/
    function registration(array $parameters);

    /*Регистрация успешно проведена*/
    function registration_ok(array $parameters);

    /*Авторизация*/
    function authorize(array $parameters);

    /*Сброс авторизации*/
    function unauthorize(array $parameters);

    /*Данные авторизованного пользователя*/
    function authorized_data(array $parameters);

    /*Подтверждение успешной авторизации*/
    function authorized_ok(array $parameters);

    /*Подтверждение успешного выхода из авторизации*/
    function unauthorized_ok(array $parameters);

    /*Проверка псевдонима на зарегистрированность*/
    function check_nickname_registration(array $parameters, $nickname=null);

    /*Проверка псевдонима на не зарегистрированность*/
    function check_nickname_no_registration(array $parameters, $nickname=null);

    /*Проверка доступности электронной почты для регистрации*/
    function check_email_no_registration(array $parameters, $email=null);

    /*Проверка правильного пароля по псеводиму*/
    function check_password_valid_by_nickname(array $parameters, $password=null, $nickname=null);
}
