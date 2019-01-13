<?php

namespace Framework_life_balance\core_components\experiences;

/**
 * Наработка index
 *
 * @package Framework_life_balance\core_components\experiences
 */
interface Structure_index
{
    /**
     * Главная страница
     *
     * @param array $parameters параметры
     * @return array
     */
    function index(array $parameters);

    /**
     * Страница ошибки
     *
     * @param array $parameters параметры
     * @return array
     */
    function error(array $parameters);

    /**
     * Блокировка доступа по причине губительного влияния
     *
     * @param array $parameters параметры
     * @return array
     */
    function stop(array $parameters);

    /**
     * Блокировка доступа по причине технических работ
     *
     * @param array $parameters параметры
     * @return array
     */
    function engineering_works(array $parameters);

    /**
     * Сообщение об ошибке
     *
     * @param array $parameters параметры
     * @return array
     */
    function send_error(array $parameters);

    /**
     * Выдача sitemap.xml
     *
     * @param array $parameters параметры
     * @return string $xml
     */
    function site_map_xml(array $parameters);

    /**
     * Карта сайта
     *
     * @param array $parameters параметры
     * @return array
     */
    function site_map(array $parameters);

}
