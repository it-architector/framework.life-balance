<?php

namespace Framework_life_balance\core_components;

interface Structure_Resources
{

    /**
     * Подготавливаем работу с ресурсами
     *
     * @return null
     */
    static function initiation();

    /*---------------------------------------------------------*/
    /*-------------------------СХЕМЫ---------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Схема наработки
     *
     * @param string $experience наработка
     * @param string $goal цель
     * @param string $detail деталь
     * @return array|boolean
     */
    static function schema_experience($experience = null, $goal = null, $detail = null );

    /**
     * Схема базы данных
     *
     * @param string $table показать данные определенной таблицы
     * @param string $column показать данные определенной колонки
     * @param string $detail деталь
     * @return array|boolean
     */
    static function schema_data_base($table = null, $column = null, $detail = null);

    /**
     * Сохраняем реализованную схему базы данных
     *
     * @param array $realized_schema реализованная схема
     * @return null
     */
    static function save_realized_schema_data_base($realized_schema);

    /**
     * Получаем информацию реализованной схемы базы данных
     *
     * @return array $realized_schema
     */
    static function get_information_realized_schema_data_base();

    /*---------------------------------------------------------*/
    /*---------------------КОММУНИКАЦИИ------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Создаем коммуникацию с базой данных
     *
     * @return boolean
     */
    static function create_communication_with_data_base();

    /**
     * Завершаем коммуникацию с базой данных
     *
     * @return boolean
     */
    static function complete_communication_with_data_base();

    /**
     * Создаем коммуникацию с памятью
     *
     * @return boolean
     */
    static function create_communication_with_memory();

    /**
     * Завершаем коммуникацию с памятью
     *
     * @return boolean
     */
    static function complete_communication_with_memory();

    /**
     * Создаем коммуникацию с почтой
     *
     * @return boolean
     */
    static function create_communication_with_mail();

    /**
     * Завершаем коммуникацию с почтой
     *
     * @return boolean
     */
    static function complete_communication_with_mail();

    /*---------------------------------------------------------*/
    /*---------------------ВЗАИМОДЕЙСТВИЕ----------------------*/
    /*---------------------------------------------------------*/

    /*--------ФАЙЛОВОЕ ХРАНИЛИЩЕ------*/

    /**
     * Записываем информацию в файл
     *
     * @param string $dir папка
     * @param string $name название файла
     * @param string $type тип файла
     * @param string $information текст
     * @return null
     */
    static function write_information_in_file($dir, $name, $type, $information);

    /**
     * Подключаем информацию из файла
     *
     * @param string $dir папка
     * @param string $name название файла
     * @param string $type тип файла
     * @return array|string|boolean
     */
    static function include_information_from_file($dir, $name, $type);

    /**
     * Удаляем файл
     *
     * @param string $dir папка
     * @param string $name название файла
     * @param string $type тип файла
     * @return null
     */
    static function delete_file($dir, $name, $type);

    /*------ДОБАВЛЕНИЕ ИНФОРМАЦИИ В БАЗУ ДАННЫХ------*/

    /**
     * Добавляем в базу данных пользователя
     *
     * @param string $nickname псевдоним
     * @param string $password_formation сформированный пароль
     * @param string $name имя
     * @param string $family_name фамилия
     * @param string $email электронный адрес
     * @return integer|boolean
     */
    static function data_base_add_user($nickname, $password_formation, $name, $family_name, $email);

    /**
     * Добавляем запрос консоли в базу данных
     *
     * @param string $experience наработка
     * @param string $experience_goal цель
     * @param array $parameters параметры
     * @return integer|false
     */
    static function add_request_console_in_data_base($experience, $experience_goal, array $parameters);

    /*------ПОЛУЧЕНИЕ КОЛИЧЕСТВА ИНФОРМАЦИИ ИЗ БАЗЫ ДАННЫХ------*/

    /**
     * Получаем из базы данных кол-во всех пользователей
     *
     * @return integer|boolean
     */
    static function data_base_get_count_users();

    /*------ПОЛУЧЕНИЕ ИНФОРМАЦИИ ИЗ БАЗЫ ДАННЫХ------*/

    /**
     * Получаем из базы данных всех пользователей
     *
     * @return array|boolean
     */
    static function data_base_get_users();

    /**
     * Получаем из базы данных id пользователя по авторизационым данным
     *
     * @param string $nickname псевдоним
     * @param string $password_formation сформированный пароль
     * @return string|boolean
     */
    static function data_base_get_user_id_by_auth_data($nickname, $password_formation);

    /**
     * Получаем из базы данных id пользователя по псевдониму
     *
     * @param string $nickname псевдоним
     * @return string|boolean
     */
    static function data_base_get_user_id_by_nickname($nickname);

    /**
     * Получаем из базы данных информацию о пользователе по сессии
     *
     * @param integer $user_id индификационный номер пользователя
     * @param integer $session сессия пользователя
     * @return array|boolean $user_data
     */
    static function data_base_get_user_data_by_session($user_id, $session);

    /**
     * Получаем из базы данных id пользователя по электронному адресу
     *
     * @param string $email электронный адрес
     * @return string|boolean
     */
    static function data_base_get_user_id_by_email($email);

    /**
     * Берём запрос консоли по id из базы данных
     *
     * @param integer $id идентификатор
     * @return array|false
     */
    static function get_request_console_by_id_from_data_base($id);

    /*------ОБНОВЛЕНИЕ ИНФОРМАЦИИ В БАЗЕ ДАННЫХ------*/

    /**
     * Обновляем в базе данных роль администрирования у пользователя
     *
     * @param integer $user_id индификационный номер пользователя
     * @param string $is_admin да-нет
     * @return boolean
     */
    static function data_base_set_user_is_admin($user_id, $is_admin);

    /**
     * Обновляем в базе данных сессию у пользователя
     *
     * @param integer $user_id индификационный номер пользователя
     * @param integer $session сессия пользователя
     * @return boolean
     */
    static function data_base_upd_user_session($user_id, $session);

    /**
     * Обновляем статус запроса консоли в базе данных
     *
     * @param integer $id идентификатор
     * @param string $status статус
     * @return boolean
     */
    static function update_status_request_console_in_data_base($id, $status);

    /*------УДАЛЕНИЕ ИНФОРМАЦИИ ИЗ БАЗЫ ДАННЫХ------*/

    /*------СТРУКТУРА БАЗЫ ДАННЫХ------*/

    /**
     * Реконструируем базу данных
     *
     * @param string $changes изменения
     * @return boolean
     */
    static function reconstruction_data_base($changes);

}

?>