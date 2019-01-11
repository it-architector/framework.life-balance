<?php

namespace Framework_life_balance\core_components\experiences;

interface Structure_Index
{
    /*Главная страница*/
    function index(array $parameters);

    /*Страница ошибки*/
    function error(array $parameters);

    /*Блокировка доступа по причине губительного влияния*/
    function stop(array $parameters);

    /*Блокировка доступа по причине технических работ*/
    function engineering_works(array $parameters);

    /*Сообщение об ошибке*/
    function send_error(array $parameters);

    /*Выдача sitemap.xml*/
    function site_map_xml(array $parameters);

    /*Карта сайта*/
    function site_map(array $parameters);
}
