<?php

namespace Framework_life_balance\core_components;

/**
 * Суть ресурсов
 *
 * @package Framework_life_balance\core_components
 */
interface Structure_Resources
{

    /**
     * Подготавливаем работу с ресурсами
     *
     * @return null
     */
    static function initiation();

    /*---------------------------------------------------------*/
    /*-------------------------Схемы---------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Схема Наработки
     *
     * @param string $experience наработка
     * @param string $goal цель
     * @param string $detail деталь
     * @return array|boolean
     */
    static function schema_experience($experience = null, $goal = null, $detail = null );

    /**
     * Схема таблиц базы данных
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
     * Получаем информацию реализованной Схемы базы данных
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

    /*------БАЗА ДАННЫХ------*/

    /**
     * Взаимообмен информацией с базой данных
     *
     * @param string $direction направление
     * @param string $what чего
     * @param array $values значения
     */
    static function interchange_information_with_data_base($direction, $what, $values);

    /**
     * Реконструируем базу данных
     *
     * @param string $changes изменения
     * @return boolean
     */
    static function reconstruction_data_base($changes);

}

?>