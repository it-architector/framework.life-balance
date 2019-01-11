<?php

namespace Framework_life_balance\core_components;

/**
 * Суть уведомлений
 *
 * @package Framework_life_balance\core_components
 */
interface Structure_Notices
{

    /**
     * Определяем вывод информации
     *
     * @return null
     */
    static function initiation();

    /*---------------------------------------------------------*/
    /*---------------------ПРЕДНАЗНАЧЕНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Устанавливаем предназначение
     *
     * @param string $key ключ
     * @param string $value значение
     */
    static function set_mission($key,$value);

    /**
     * Получаем предназначение
     *
     * @param string $key ключ
     * @return string|array|null $value значение
     */
    static function get_mission($key);

    /**
     * Удаляем предназначение
     *
     * @param string $key ключ
     */
    static function delete_mission($key);

    /**
     * Удаляем все предназначения
     *
     * @return null
     */
    static function delete_all_missions();

    /*---------------------------------------------------------*/
    /*----------------------ОТНОШЕНИЯ--------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Результат выполнения в интерфейс
     *
     * @return string null
     */
    static function result_executed_to_interface();

    /**
     * Сообщение на почту
     *
     * @param string $email электронный адрес получателя
     * @param string $title заголовок
     * @param string $text текст
     * @param string $template шаблон
     * @return boolean
     */
    static function message_to_mail($email, $title, $text, $template);

}