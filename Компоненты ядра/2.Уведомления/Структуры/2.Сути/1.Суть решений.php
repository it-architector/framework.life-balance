<?php

namespace Framework_life_balance\core_components;

/**
 * Суть решений
 *
 * @package Framework_life_balance\core_components
 */
interface Structure_Solutions
{
    /**
     * Включаем контроль ядра
     *
     * @return null
     */
    static function initiation();

    /*---------------------------------------------------------*/
    /*-----------------------КОНТРОЛЬ--------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Проверяем запрос на правомерность
     *
     * @return null
     */
    static function check_request_legality();

    /**
     * Проверяем запрос на деструктив
     *
     * @return null
     */
    static function check_request_destructive();

    /**
     * Проверяем изменения в схеме базы данных
     *
     * @return null
     */
    static function check_changes_schema_data_base();

    /**
     * Проверяем правомерность запроса
     *
     * @return boolean
     */
    static function check_request_access();

    /**
     * Проверяем правильное взятие Схемы наработок
     *
     * @param string $experience наработка
     * @param string $goal цель
     * @param string $detail деталь
     * @param string $call_index_goal_on_error вызвать наработанную index цель при ошибке
     */
    static function check_correct_taking_schema_experience($experience = null, $goal = null, $detail = null, $call_index_goal_on_error = 'error');

    /**
     * Проверяем правильное взятие Схемы базы данных
     *
     * @param string $table наработка
     * @param string $column цель
     * @param string $detail деталь
     * @param string $call_index_goal_on_error вызвать наработанную index цель при ошибке
     */
    static function check_correct_taking_schema_data_base($table = null, $column = null, $detail = null, $call_index_goal_on_error = 'error');

    /**
     * Позиция во времени
     *
     * @param string $format формат даты
     * @return string $date
     * @throws
     */
    static function position_time($format = 'Y-m-d H:i:s');

    /**
     * Помечаем начало выполнения Наработки
     *
     * @return null
     */
    static function mark_start_execution_experience();

    /**
     * Помечаем завершение выполнения Наработки
     *
     * @return null
     */
    static function mark_stop_execution_experience();

    /**
     * Выявляем ошибку
     *
     * @return null
     */
    static function detect_error();

    /**
     * Определяем операционную систему
     *
     * @return null
     */
    static function detect_operating_system();

    /**
     * Определяем путь до исполнителя PHP
     *
     * @return string
     */
    static function detect_path_executable_php();

    /**
     * Проверяем правомерность ответа
     *
     * @return null
     */
    static function check_answer_correct();

    /**
     * Прекращаем работу ядра
     *
     * @return null
     */
    static function stop_core();

    /*---------------------------------------------------------*/
    /*-------------------СТРУКТУРИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Разбираем запрос
     *
     * @return null
     */
    static function parse_request();

    /**
     * Разбираем параметры запроса
     *
     * @return null
     */
    static function parse_parameters_request();

    /**
     * Разбираем авторизованность
     *
     * @return null
     */
    static function parse_authorized();

    /**
     * Формируем класс Наработки
     *
     * @param string $experience наработка
     * @return object
     */
    static function construct_class_experience($experience);

    /**
     * Формируем сессию пользователя
     *
     * @param string $user_id индификационный номер пользователя
     * @return string $session сессия пользователя
     */
    static function formation_user_session($user_id);

    /**
     * Формируем пароль пользователя
     *
     * @param string $password пароль пользователя
     * @return string $password_formation сформированный пароль пользователя
     */
    static function formation_user_password($password);

    /**
     * Формируем результат выполенения в интерфейс
     *
     * @return string $answer текст ответа
     */
    static function formation_result_executed_to_interface();

    /**
     * Определение удалённого адреса пользователя
     *
     * @return string $user_ip
     */
    static function definition_user_ip();

    /**
     * Формирование шаблона
     *
     * @param string $template шаблон
     * @param array $parameters параметры
     * @return string
     */
    static function formation_template($template,$parameters);

    /**
     * Формирование ссылки проекта
     *
     * @return string
     */
    static function formation_url_project();

    /**
     * Формируем консольную консольную команду вызова Наработки
     *
     * @param string $experience наработка
     * @param string $experience_goal цель
     * @param integer $id_save_parameters id сохранённых параметров
     * @return string
     */
    static function formation_console_command_call_experience($experience, $experience_goal, $id_save_parameters);

    /**
     * Сопоставляем Схемы базы данных
     *
     * @param array $realized_schema реализованная схема
     * @param array $current_schema текущая схема
     * @return array|false
     */
    static function matching_schema_data_base($realized_schema, $current_schema);
}