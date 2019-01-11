<?php

namespace Framework_life_balance\core_components\their_modules;

/**
 * Модуль базы данных mysql (pdo)
 *
 * @package Framework_life_balance\core_components\their_modules
 */
interface Structure_Data_Base
{

    /*---------------------------------------------------------*/
    /*----------------------ОТНОШЕНИЯ--------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Передаём запрос в базу данных
     *
     * @param string $query запрос
     * @return boolean $result
     * @throws
     */
    static function send_request_to_data_base($query);

    /**
     * Передаём установки для работы с информацией в базе данных
     *
     * @return null
     * @throws
     */
    static function send_greeting_to_data_base();

    /*---------------------------------------------------------*/
    /*-----------------------КОНТРОЛЬ--------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Фиксируем ошибку
     *
     * @param string $message сообщение
     * @throws \Exception
     */
    static function fix_error($message);

    /*---------------------------------------------------------*/
    /*-------------------СТРУКТУРИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * формируем запрос на добавление информации
     *
     * @param string $table таблица
     * @param array $set установка
     * @return array
     * @throws
     */
    static function formation_query_add_information($table, $set);

    /**
     * формируем запрос на получение информации
     *
     * @param string $table таблица
     * @param array|false $select колонки
     * @param array|false $where уточнение
     * @param array|false $sort сортировка
     * @param array|string|false $limit ограничение
     * @return array
     * @throws
     */
    static function formation_query_get_information($table,  $select,  $where, $sort, $limit);

    /**
     * формируем запрос на количество информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @return array
     * @throws
     */
    static function formation_query_count_information($table, $where);

    /**
     * формируем запрос на обновление информации
     *
     * @param string $table таблица
     * @param array|false $set установка
     * @param array|false $where уточнение
     * @param array|string|false $limit ограничение
     * @return array
     * @throws
     */
    static function formation_query_update_information($table, $set, $where, $limit);

    /**
     * формируем запрос на удаление информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @param array|string|false $limit ограничение
     * @return array
     * @throws
     */
    static function formation_query_delete_information($table, $where, $limit);

    /**
     * формируем запрос на создание Структуры таблицы
     *
     * @param string $table таблица
     * @param string $intended предназначение
     * @param string $primary_column первичная колонка
     * @param string|array $type_primary_column тип колонки
     * @param string $default_primary_column по умолчанию у колонки
     * @param string $intended_primary_column предназначение колонки
     * @return string $query
     * @throws
     */
    static function formation_query_create_structure_table($table, $intended, $primary_column, $type_primary_column, $default_primary_column, $intended_primary_column);

    /**
     * формируем запрос на создание Структуры колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string|array $type_column тип колонки
     * @param string $default_column по умолчанию у колонки
     * @param string $intended_column предназначение колонки
     * @return string $query
     * @throws
     */
    static function formation_query_create_structure_column($table, $column, $type_column, $default_column, $intended_column);

    /**
     * формируем запрос на создание в структуре сортировки
     *
     * @param string $table таблица
     * @param string $index индекс
     * @param boolean $unique_sorting уникальность сортировки
     * @param array $columns_index колонки сортировки
     * @return string $query
     * @throws
     */
    static function formation_query_create_structure_sorting($table, $index, $unique_sorting, $columns_index);

    /**
     * формируем запрос на создание в структуре связей
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string $default_column значение по умолчанию у колонки
     * @param string $table_reference таблица связи
     * @param string $column_reference колонка связи
     * @param string|false $action_update_column_reference действие при обновлении колонки связи
     * @param string|false $action_delete_column_reference действие при удаление колонки связи
     * @return string $query
     * @throws
     */
    static function formation_query_create_structure_reference($table, $column, $default_column, $table_reference, $column_reference, $action_update_column_reference, $action_delete_column_reference);

    /**
     * формируем запрос на удаление в структуре связи
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string $table_reference таблица связи
     * @param string $column_reference колонка связи
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_reference($table, $column, $table_reference, $column_reference);

    /**
     * формируем запрос на удаление в структуре сортировки
     *
     * @param string $table таблица
     * @param string $index индекс
     * @param boolean $unique_sorting уникальность сортировки
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_sorting($table, $index, $unique_sorting);

    /**
     * формируем запрос на удаление в структуре колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_column($table, $column);

    /**
     * формируем запрос на удаление в структуре таблицы
     *
     * @param string $table таблица
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_table($table);

    /**
     * формируем запрос на изменения в структуре колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string|array $type_column тип колонки
     * @param string $default_column по умолчанию у колонки
     * @param string $intended_column предназначение колонки
     * @return string $query
     * @throws
     */
    static function formation_query_correct_structure_column($table, $column, $type_column, $default_column, $intended_column);

    /**
     * Экранизируем значение
     *
     * @param string $string значение
     * @param string|false $limiter ограничения
     * @return string $string экранизированное значение
     */
    static function adaptation_value($string, $limiter = false);

    /**
     * Формируем поля и проявляем значения запроса
     *
     * @param array $values_query все значения ключей
     * @param string $format формат
     * @param array $values значения
     * @param integer|false $num_group_add номер группы добавления
     * @return string
     */
    static function formation_fields_and_manifestation_values_query(&$values_query, $format, $values,  $num_group_add = false);

    /*---------------------------------------------------------*/
    /*---------------------КОММУНИКАЦИИ------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Создаем коммуникацию с базой данных
     *
     * @param string $host драйвер
     * @param string $name драйвер
     * @param string $schema драйвер
     * @param string $user драйвер
     * @param string $pass драйвер
     * @param string $file_log файл для лога
     * @return null
     * @throws
     */
    static function create_communication_with_data_base($host,$name,$schema,$user,$pass,$file_log=null);

    /**
     * Завершаем коммуникацию с базой данных
     *
     * @return boolean
     */
    static function complete_communication_with_data_base();

    /**
     * Создаем коммуникацию с распределителем запроса
     *
     * @param string $query запрос
     * @return object|boolean $distributor_query
     */
    static function create_communication_with_distributor_query($query);

    /*---------------------------------------------------------*/
    /*---------------------ВЗАИМОДЕЙСТВИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Получаем записи по запросу
     *
     * @param object $link_communication_with_table ссылка на коммуникацию с таблицей
     * @return array|boolean $result
     */
    static function get_rows($link_communication_with_table);

    /**
     * Получаем последний индификационный номер по последнему запросу
     *
     * @return integer|boolean $result
     */
    static function get_last_auto_increment_id();

    /**
     * Получаем количество записей
     *
     * @param object $link_communication_with_table ссылка на коммуникацию с таблицей
     * @return integer|boolean $result
     */
    static function get_count_rows($link_communication_with_table);

    /**
     * Получаем результат выполнения запроса
     *
     * @param string $type_query тип запроса
     * @param object $distributor_query распределитель запросов
     * @param array|string|false $limit ограничение
     * @return array|false
     */
    static function get_result_executed_query($type_query, $distributor_query, $limit = false);

    /*---------------------------------------------------------*/
    /*------------------------ДЕЙСТВИЕ-------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Выполняем запрос
     *
     * @param string $query запрос
     * @param array $values значения запроса
     * @return object|boolean $distributor_query распределитель запросов
     * @throws \Exception
     */
    static function execute_query($query, $values = array());

    /*---------------------------------------------------------*/
    /*----------------------ДЕЛЕГИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Вызываем добавление информации
     *
     * @param string $table таблица
     * @param array|false $set установка
     * @return integer|false
     * @throws
     */
    static function call_add_information($table, $set = false);

    /**
     * Вызываем групповое добавление информации
     *
     * @param string $table таблица
     * @param array|false $set установка
     * @return integer|false
     * @throws
     */
    static function call_group_add_information($table, $set = false);

    /**
     * Вызываем получение информации
     *
     * @param string $table таблица
     * @param array|false $select колонки
     * @param array|false $where уточнение
     * @param array|false $limit ограничение
     * @param array|false $sort сортировка
     * @return array|false
     * @throws
     */
    static function call_get_information($table, $select, $where = false, $sort = false, $limit = false);

    /**
     * Вызываем количество информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @return integer|false
     * @throws
     */
    static function call_count_information($table, $where = false);

    /**
     * Вызываем обновление информации
     *
     * @param string $table таблица
     * @param array|false $set установка
     * @param array|false $where уточнение
     * @param array|false $limit ограничение
     * @return integer|false
     * @throws
     */
    static function call_update_information($table, $set = false, $where = false, $limit = false);

    /**
     * Вызываем удаление информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @param array|false $limit ограничение
     * @return integer|false
     * @throws
     */
    static function call_delete_information($table, $where = false, $limit = false);

    /**
     * Вызов создания Структуры таблицы
     *
     * @param string $table таблица
     * @param string $intended предназначение
     * @param string $primary_column первичная колонка
     * @param string|array $type_primary_column тип колонки
     * @param string $default_primary_column по умолчанию у колонки
     * @param string $intended_primary_column предназначение колонки
     * @return boolean
     * @throws
     */
    static function call_create_structure_table($table, $intended, $primary_column, $type_primary_column, $default_primary_column, $intended_primary_column);

    /**
     * Вызов создания Структуры колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string|array $type_column тип колонки
     * @param string $default_column значение по умолчанию у колонки
     * @param string $intended_column предназначение колонки
     * @return boolean
     * @throws
     */
    static function call_create_structure_column($table, $column, $type_column, $default_column, $intended_column);

    /**
     * Вызов создания Структуры сортировки
     *
     * @param string $table таблица
     * @param string $index индекс
     * @param boolean $unique_sorting уникальность сортировки
     * @param array $columns_index колонки сортировки
     * @return boolean
     * @throws
     */
    static function call_create_structure_sorting($table, $index, $unique_sorting, $columns_index);

    /**
     * Вызов создания Структуры связи
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string $default_column значение по умолчанию у колонки
     * @param string $table_reference таблица связи
     * @param string $column_reference колонка связи
     * @param string|false $action_update_column_reference действие при обновлении колонки связи
     * @param string|false $action_delete_column_reference действие при удаление колонки связи
     * @return boolean
     * @throws
     */
    static function call_create_structure_reference($table, $column, $default_column, $table_reference, $column_reference, $action_update_column_reference, $action_delete_column_reference);

    /**
     * Вызов удаления Структуры связи
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string $table_reference таблица связи
     * @param string $column_reference колонка связи
     * @return boolean
     * @throws
     */
    static function call_delete_structure_reference($table, $column, $table_reference, $column_reference);

    /**
     * Вызов удаления Структуры сортировки
     *
     * @param string $table таблица
     * @param string $index индекс
     * @param boolean $unique_sorting уникальность сортировки
     * @return boolean
     * @throws
     */
    static function call_delete_structure_sorting($table, $index, $unique_sorting);

    /**
     * Вызов удаление Структуры колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @return boolean
     * @throws
     */
    static function call_delete_structure_column($table, $column);

    /**
     * Вызов удаление Структуры таблицы
     *
     * @param string $table таблица
     * @return boolean
     * @throws
     */
    static function call_delete_structure_table($table);

    /**
     * Вызов изменения Структуры колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @param string|array $type_column тип колонки
     * @param string $default_column по умолчанию у колонки
     * @param string $intended_column предназначение колонки
     * @return boolean
     * @throws
     */
    static function call_correct_structure_column($table, $column, $type_column, $default_column, $intended_column);

}

?>