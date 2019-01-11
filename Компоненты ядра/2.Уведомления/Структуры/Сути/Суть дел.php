<?php 

namespace Framework_life_balance\core_components;

interface Structure_Business
{

    /**
     * Подготавливаем работу с наработками
     *
     * @return null
     */
    static function initiation();

    /*---------------------------------------------------------*/
    /*------------------------ДЕЙСТВИЕ-------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Выполняем запрошенную наработанную цель
     *
     * @return null
     */
    static function execute_request_experience_goal();

    /**
     * Фиксируем ошибку
     *
     * @param string $error_message текст ошибки
     * @param string $file_name файл где произошла ошибка
     * @param string $num_line_on_file_error номер строчки в файле где произошла ошибка
     * @param string|false $call_index_goal_on_error вызвать наработку index Цели при ошибке
     * @return null
     */
    static function fix_error($error_message, $file_name = null, $num_line_on_file_error = null, $call_index_goal_on_error = 'error');

    /*---------------------------------------------------------*/
    /*----------------------ДЕЛЕГИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Вызываем наработку
     *
     * @param string $experience наработка
     * @param string $experience_goal наработанная цель
     * @param array $parameters параметры
     * @return null
     */
    static function call_experience($experience, $experience_goal, array $parameters);

    /**
     * Вызываем консольную наработку
     *
     * @param string $experience наработка
     * @param string $experience_goal цель
     * @param array $parameters параметры
     * @return null
     */
    static function call_console_experience($experience, $experience_goal, array $parameters);

    /*---------------------------------------------------------*/
    /*------------------------ПАМЯТЬ---------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Работаем с оперативной памятью
     *
     * @param string $name обозначение ячейки памяти
     * @param string|integer|array|boolean $value_update значение для записи
     * @param integer|boolean $time_update время хранения в сек.
     * @param boolean $clear очистка ячейки
     * @return string|integer|array $value
     */
    static function work_with_memory_data($name,$value_update=false, $time_update=false, $clear = false);

    /**
     * Данные авторизованного пользователя
     *
     * @param string $detail показать определенную часть данных
     * @return array|string|boolean
     */
    static function data_authorized_user($detail=null);

}