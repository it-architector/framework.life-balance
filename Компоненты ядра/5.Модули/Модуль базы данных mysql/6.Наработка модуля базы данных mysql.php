<?php

namespace Framework_life_balance\core_components\their_modules;


/**
 * Модуль базы данных mysql (pdo)
 *
 * @package Framework_life_balance\core_components\their_modules
 *
 */
class Data_Base
{

    /*---------------------------------------------------------*/
    /*---------------------ПРЕДНАЗНАЧЕНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /*название Схемы базы данных*/
    static $schema = null;

    /*ссылка на коммуникацию с базой данных*/
    static $link_communication_with_data_base = null;

    /*файл для лога*/
    static $file_log = null;

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
    static function send_request_to_data_base($query)
    {

        /* Фиксируем запрос */
        self::fix_query($query);


        if (!is_null(self::$link_communication_with_data_base)) {
            try {
                $request = self::$link_communication_with_data_base->query($query);
                $request->setFetchMode(\PDO::FETCH_ASSOC);
                return true;
            } catch (\PDOException $e) {
                self::fix_error($e->getMessage());
            }
        }
    }

    /**
     * Передаём установки для работы с информацией в базе данных
     *
     * @return null
     * @throws
     */
    static function send_greeting_to_data_base()
    {
        self::send_request_to_data_base('SET NAMES utf8');
        self::send_request_to_data_base('SET CHARACTER SET utf8');

    }

    /*---------------------------------------------------------*/
    /*-------------------СТРУКТУРИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Формируем установки
     *
     * @param array $set установки
     * @return string
     * @throws
     */
    static function formation_set($set){

        $query = '';

        if(count($set) > 0){

            /* Установливаем колонки */
            $set_columns = [];

            foreach($set as $set_column=>$set_value){

                $set_columns[] = self::adaptation_value($set_column, 'column') . ' = ' . self::adaptation_value($set_value, 'external_value_or_formula');

            }

            /* Совмещаем установку */
            $query = 'SET ' . implode( ', ',  $set_columns );

            /*
            foreach($set as $set_column=>$set_value){
                $set_columns[] = self::adaptation_value($set_column, 'column');
                $set_values[]  = self::adaptation_value($set_value, 'external_value_or_formula', $set_column);
            }
            $query = '(' . implode( ', ',  $set_columns ) . ') VALUES ' . '(' .implode( ', ',  $set_values ) . ')';
            */

        }

        return $query;

    }

    /**
     * Формируем уточнение
     *
     * @param array $where уточнение
     * @return string
     * @throws
     */
    static function formation_where($where){

        $query = '';

        /* Уточнение */
        if(count($where) > 0){

            /* Уточняем колонки */
            $where_columns = [];


            foreach($where as $where_row){

                if(is_array($where_row)){

                    $where_columns[] = self::adaptation_value($where_row[0], 'column') . ' ' . $where_row[1] . ' ' . self::adaptation_value($where_row[2], 'external_value_or_formula');

                }
                else{

                    $where_columns[] = $where_row;

                }

            }

            $query = 'WHERE ' . implode(' ', $where_columns);
        }

        return $query;

    }

    /**
     * Формируем сортировку
     *
     * @param array $sort сортировка
     * @return string
     * @throws
     */
    static function formation_sort($sort){

        $query = '';

        /* Сортируем */
        if($sort and count($sort) > 0){

            /* Сортируем колонки */
            $sort_columns = [];

            foreach($sort as $sort_column => $sort_direction){

                $sort_columns[] = self::adaptation_value($sort_column, 'column') . ' ' . $sort_direction;

            }

            $query = 'ORDER BY ' . implode( ', ' , $sort_columns );

        }

        return $query;

    }

    /**
     * Формируем ограничение
     *
     * @param integer|false $position_first_row Позиция первой записи
     * @param integer|false $limit Количество записей
     * @return string
     * @throws
     */
    static function formation_limit($position_first_row, $limit){

        $query = '';

        if($limit){
            if($position_first_row){
                $query = 'LIMIT ' . $position_first_row . ',' . $limit;
            }
            else{
                $query = 'LIMIT ' . $limit;
            }
        }

        return $query;

    }

    /**
     * Корректируем ограничение
     *
     * @param integer|false $position_first_row Позиция первой записи
     * @param array $values значения
     * @return integer|false
     * @throws
     */
    static function correct_limit($position_first_row, $values){

        if($position_first_row and isset($values[$position_first_row])){

            /* Подменяем обозначение значением */
            $position_first_row = $values[$position_first_row];
        }
        else{
            $position_first_row = false;
        }

        return $position_first_row;

    }

    /**
     * Формируем запрос на добавление информации
     *
     * @param string $table Таблица
     * @param array $set Передачи
     * @return string
     * @throws
     */
    static function formation_query_add_information($table, $set){

        /* Запрос */
        $query = [];

        /* Обращаемся к таблице */
        $query[] = 'INSERT INTO ' . self::adaptation_value($table, 'table');

        /* Установливаем */
        $query[] = self::formation_set($set);

        /* Готовый запрос */
        return implode(' ', $query);

    }

    /**
     * формируем запрос на получение информации
     *
     * @param string $table таблица
     * @param array|false $select взятие
     * @param array|false $where уточнение
     * @param array|false $sort сортировка
     * @param integer|false $positions_first_row Позиция первой записи
     * @param integer|false $limit Количество записей
     * @return string
     * @throws
     */
    static function formation_query_get_information($table,  $select,  $where, $sort, $positions_first_row, $limit){

        /* Запрос */
        $query = [];

        /* Берём значения колонок */
        if(is_array($select)){

            /* Берём значения колонок */
            $select_columns = [];

            foreach($select as $select_column){
                $select_columns[] = self::adaptation_value($select_column, 'column');
            }

            $query[] = 'SELECT ' . implode(', ', $select_columns);
        }
        else{
            $query[] = 'SELECT *';
        }

        /* Обращаемся к таблице */
        $query[] = 'FROM ' . self::adaptation_value($table,'table');

        /* Уточнение */
        $query[] = self::formation_where($where);

        /* Сортируем */
        $query[] = self::formation_sort($sort);

        /* Ограничиваем */
        $query[] = self::formation_limit($positions_first_row, $limit);

        /* Готовый запрос */
        return implode( ' ', $query );

    }

    /**
     * формируем запрос на количество информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @return string
     * @throws
     */
    static function formation_query_count_information($table, $where){

        /* Запрос */
        $query = [];

        /* Берём значения колонок */
        $query[] = 'SELECT count(*) as count';

        /* Обращаемся к таблице */
        $query[] = 'FROM ' . self::adaptation_value($table,'table');

        /* Уточнение */
        $query[] = self::formation_where($where);

        /* Ограничиваем */
        $query[] = 'LIMIT 1';

        /* Готовый запрос */
        return implode( ' ', $query );

    }

    /**
     * формируем запрос на обновление информации
     *
     * @param string $table таблица
     * @param array|false $set Передача
     * @param array|false $where уточнение
     * @param integer|false $limit Количество записей
     * @return string
     * @throws
     */
    static function formation_query_update_information($table, $set, $where, $limit){

        /* Запрос */
        $query = [];

        /* Обращаемся к таблице */
        $query[] = 'UPDATE ' . self::adaptation_value($table,'table');

        /* Установливаем */
        $query[] = self::formation_set($set);

        /* Уточнение */
        $query[] = self::formation_where($where);

        /* Ограничиваем */
        $query[] = self::formation_limit(false, $limit);

        /* Готовый запрос */
        return implode( ' ', $query );

    }

    /**
     * формируем запрос на удаление информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @param integer|false $limit Количество записей
     * @return string
     * @throws
     */
    static function formation_query_delete_information($table, $where, $limit){

        /* Запрос */
        $query = [];

        /* Обращаемся к таблице */
        $query[] = 'DELETE FROM ' . self::adaptation_value($table,'table');

        /* Уточнение */
        $query[] = self::formation_where($where);

        /* Ограничиваем */
        $query[] = self::formation_limit(false, $limit);

        /* Готовый запрос */
        return implode( ' ', $query );

    }

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
    static function formation_query_create_structure_table($table, $intended, $primary_column, $type_primary_column, $default_primary_column, $intended_primary_column){


        if(is_array($type_primary_column)){
            if(key($type_primary_column) == 'enum'){
                $type_primary_column = 'enum("'.implode('","',$type_primary_column[key($type_primary_column)]).'")';
            }
            else{
                $type_primary_column = key($type_primary_column).'('.$type_primary_column[key($type_primary_column)].')';
            }
        }

        if($default_primary_column == '{auto_increment}'){
            $default_primary_column = ' auto_increment';
        }
        elseif($default_primary_column === null){
            $default_primary_column = ' null';
        }
        else{
            $default_primary_column = ' not null default '.self::adaptation_value($default_primary_column);
        }

        $query = 'create table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' ('.self::adaptation_value($primary_column,'`').' '.$type_primary_column.$default_primary_column.' primary key comment '.self::adaptation_value($intended_primary_column).') comment '.self::adaptation_value($intended);

        return $query;

    }

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
    static function formation_query_create_structure_column($table, $column, $type_column, $default_column, $intended_column){


        if(is_array($type_column)){
            if(key($type_column) == 'enum'){
                $type_column = 'enum("'.implode('","',$type_column[key($type_column)]).'")';
            }
            else{
                $type_column = key($type_column).'('.$type_column[key($type_column)].')';
            }
        }

        if($default_column == '{auto_increment}'){
            $default_column = ' auto_increment';
        }
        elseif($default_column === null){
            $default_column = ' null';
        }
        else{
            $default_column = ' not null default '.self::adaptation_value($default_column);
        }

        $query = 'alter table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' add '.self::adaptation_value($column,'`').' '.$type_column . $default_column.' comment '.self::adaptation_value($intended_column);

        return $query;

    }

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
    static function formation_query_create_structure_sorting($table, $index, $unique_sorting, $columns_index){

        $index = $table.'_'.$index.'_'.(($unique_sorting)?'u':'').'index';

        $query = 'create'.(($unique_sorting)?' unique':'').' index '.self::adaptation_value($index,'`').' on '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' (`'.implode('`,`',$columns_index).'`)';

        return $query;

    }

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
    static function formation_query_create_structure_reference($table, $column, $default_column, $table_reference, $column_reference, $action_update_column_reference, $action_delete_column_reference){


        /*действие при обновлении внешней записи*/
        if($action_update_column_reference == '{synchronization}'){
            $action_update_column_reference = ' on update cascade';
        }
        elseif($action_update_column_reference == '{set_default}' and $default_column == '{null}'){
            $action_update_column_reference = ' on update set null';
        }
        elseif($action_update_column_reference == '{set_default}' and $default_column != '{null}'){
            $action_update_column_reference = ' on update set default';
        }
        else{
            $action_update_column_reference = '';
        }

        /*действие при удалении внешней записи*/
        if($action_delete_column_reference == '{synchronization}'){
            $action_delete_column_reference = ' on delete cascade';
        }
        elseif($action_delete_column_reference == '{set_default}' and $default_column == '{null}'){
            $action_delete_column_reference = ' on delete set null';
        }
        elseif($action_delete_column_reference == '{set_default}' and $default_column != '{null}'){
            $action_delete_column_reference = ' on delete set default';
        }
        else{
            $action_delete_column_reference = '';
        }

        $reference = $table.'_'.$column.'_'.$table_reference.'_'.$column_reference.'_fk';

        $query = 'alter table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' add constraint '.self::adaptation_value($reference,'`').' foreign key ('.self::adaptation_value($column,'`').') references '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table_reference,'`').' ('.self::adaptation_value($column_reference,'`').')'.$action_update_column_reference.$action_delete_column_reference;

        return $query;

    }

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
    static function formation_query_delete_structure_reference($table, $column, $table_reference, $column_reference){

        $reference = $table.'_'.$column.'_'.$table_reference.'_'.$column_reference.'_fk';

        $query = 'alter table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' drop foreign key '.self::adaptation_value($reference,'`');

        return $query;

    }

    /**
     * формируем запрос на удаление в структуре сортировки
     *
     * @param string $table таблица
     * @param string $index индекс
     * @param boolean $unique_sorting уникальность сортировки
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_sorting($table, $index, $unique_sorting){

        $index = $table.'_'.$index.'_'.(($unique_sorting)?'u':'').'index';

        $query = 'drop index '.self::adaptation_value($index,'`').' on '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`');

        return $query;

    }

    /**
     * формируем запрос на удаление в структуре колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_column($table, $column){

        $query = 'alter table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' drop column '.self::adaptation_value($column,'`');

        return $query;

    }

    /**
     * формируем запрос на удаление в структуре таблицы
     *
     * @param string $table таблица
     * @return string $query
     * @throws
     */
    static function formation_query_delete_structure_table($table){

        $query = 'drop table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`');

        return $query;

    }

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
    static function formation_query_correct_structure_column($table, $column, $type_column, $default_column, $intended_column){

        if(is_array($type_column)){
            if(key($type_column) == 'enum'){
                $type_column = 'enum("'.implode('","',$type_column[key($type_column)]).'")';
            }
            else{
                $type_column = key($type_column).'('.$type_column[key($type_column)].')';
            }
        }

        if($default_column == '{auto_increment}'){
            $default_column = ' auto_increment';
        }
        elseif($default_column == '{null}'){
            $default_column = ' null';
        }
        else{
            $default_column = ' not null default '.self::adaptation_value($default_column);
        }

        $query = 'alter table '.self::adaptation_value(self::$schema,'`').'.'.self::adaptation_value($table,'`').' modify '. self::adaptation_value($column,'`') .' '.$type_column.$default_column.' comment '. self::adaptation_value($intended_column);

        return $query;

    }

    /**
     * Экранизируем значение
     *
     * @param string|array $string значение
     * @param string|false $type тип
     * @param string|false $additional дополнительно
     * @return string|array $string экранизированное значение
     */
    static function adaptation_value($string, $type = 'value', $additional = false)
    {

        if($type == 'table'){

            $string = self::adaptation_value(self::$schema,'`') . '.' . self::adaptation_value($string,'`');

        }
        elseif($type == 'column'){

            $string = self::adaptation_value($string,'`');

        }
        elseif($type == 'external_value_or_formula'){

        }
        elseif($type == 'values'){

        }
        elseif($type == 'value'){

            if (!is_null(self::$link_communication_with_data_base)) {
                $string = self::$link_communication_with_data_base->quote($string);
            }

        }
        elseif($type){
            $string = $type . $string . $type;
        }

        return $string;
    }

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
    static function create_communication_with_data_base($host,$name,$schema,$user,$pass,$file_log=null){

        try {

            self::$schema = $schema;
            self::$file_log = $file_log;

            if(!in_array('mysql',\PDO::getAvailableDrivers())){
                throw new \Exception('mysql not setup in PDO');
            }


            $link_communication_with_data_base = new \PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $pass);

            $link_communication_with_data_base->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            self::$link_communication_with_data_base = $link_communication_with_data_base;

            /*Передаём установки для работы с информацией в базе данных*/
            self::send_greeting_to_data_base();

        } catch (\PDOException $e) {

            $error_message = iconv('windows-1251','utf-8',$e->getMessage());

            self::fix_error($error_message);
        }

    }

    /**
     * Завершаем коммуникацию с базой данных
     *
     * @return boolean
     */
    static function complete_communication_with_data_base(){

        if(self::$link_communication_with_data_base == null){
            return false;
        }

        /*Обнуляем ссылку на коммуникацию с базой данных*/
        self::$link_communication_with_data_base = null;

        return true;

    }

    /**
     * Создаем коммуникацию с распределителем запроса
     *
     * @param string $query запрос
     * @return object|boolean $distributor_query
     */
    static function create_communication_with_distributor_query($query)
    {
        $distributor_query = false;
        if (!is_null(self::$link_communication_with_data_base)) {
            $distributor_query = self::$link_communication_with_data_base->prepare($query);
            $distributor_query->setFetchMode(\PDO::FETCH_ASSOC);
        }
        return $distributor_query;
    }

    /*---------------------------------------------------------*/
    /*---------------------ВЗАИМОДЕЙСТВИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Получаем записи по запросу
     *
     * @param object $link_communication_with_table ссылка на коммуникацию с таблицей
     * @return array|boolean $result
     */
    static function get_rows($link_communication_with_table)
    {
        $result = false;
        if (is_object($link_communication_with_table)) {
            $result = $link_communication_with_table->fetch();
        }
        return $result;
    }

    /**
     * Получаем последний индификационный номер по последнему запросу
     *
     * @return integer|boolean $result
     */
    static function get_last_auto_increment_id()
    {
        $result = false;
        if (!is_null(self::$link_communication_with_data_base)) {
            $result = self::$link_communication_with_data_base->lastInsertId();
        }
        return $result;
    }

    /**
     * Получаем количество записей
     *
     * @param object $link_communication_with_table ссылка на коммуникацию с таблицей
     * @return integer|boolean $result
     */
    static function get_count_rows($link_communication_with_table)
    {
        $result = false;
        if (is_object($link_communication_with_table)) {
            $result = $link_communication_with_table->rowCount();
        }
        return $result;
    }

    /**
     * Получаем результат выполнения запроса
     *
     * @param string $type_query тип запроса
     * @param object $distributor_query распределитель запросов
     * @param integer|false $limit Количество записей
     * @return array|false
     */
    static function get_result_executed_query($type_query, $distributor_query, $limit = false)
    {

        /* Выдаём результат */
        switch ($type_query) {
            case 'Добавление информации' :
                return self::get_last_auto_increment_id();
                break;
            case 'Получение информации'  :
                if (self::get_count_rows($distributor_query) == 0){
                    return false;
                }
                elseif ($limit and $limit == 1){

                    $row = self::get_rows($distributor_query);

                    if(count($row) == 1){
                        return $row[key($row)];
                    }
                    else{
                        return $row;
                    }

                }
                else{
                    $rows = [];
                    while ($row = self::get_rows($distributor_query)) {
                        $rows[] = $row;
                    }
                    return $rows;
                }
                break;
            case 'Количество информации'  :
                if (self::get_count_rows($distributor_query) == 0){
                    return false;
                }
                $row = self::get_rows($distributor_query);
                return $row['count'];
                break;
            case 'Изменение информации'  :
            case 'Удаление информации'    :
                return true;
                break;
        }

    }

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
    static function execute_query($query, $values = array())
    {
        /* Фиксируем запрос */
        self::fix_query($query . ' | values: ' . json_encode($values));

        /*Создаем коммуникацию с распределителем запроса*/
        $distributor_query = self::create_communication_with_distributor_query($query);

        if(!$distributor_query){
            throw new \Exception('dont correct query: '.$query . ' | values: ' . json_encode($values));
        }

        if(!$distributor_query->execute($values)){
            throw new \Exception('dont execute query: '.$query . ' | values: ' . json_encode($values));
        }

        return $distributor_query;

    }

    /**
     * Фиксируем ошибку
     *
     * @param string $message сообщение
     * @throws \Exception
     */
    static function fix_error($message){
        throw new \Exception($message);
    }

    /**
     * Фиксируем запрос
     *
     * @param string $query запрос
     * @throws \Exception
     */
    static function fix_query($query){

        /*запись взаимодействий с базой данных в файл лога */
        if (self::$file_log != null){
            file_put_contents(
                self::$file_log,
                '['.date('d-m-y H:i:s').'] '.$query . "\n",
                FILE_APPEND
            );
        }

    }

    /*---------------------------------------------------------*/
    /*----------------------ДЕЛЕГИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Вызываем добавление информации
     *
     * @param string $table таблица
     * @param array $set Передачи
     * @param array $values значения
     * @return integer|false
     * @throws
     */
    static function call_add_information($table, $set, $values)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        if (!$set or count($set) == 0){
            return false;
        }

        try {

            /* Формируем запрос */
            $query = self::formation_query_add_information($table, $set);

            /* Значения */
            $values = self::adaptation_value($values, 'values');

            /* Выполняем запрос */
            $distributor_query = self::execute_query($query, $values);

            /* Получаем результат выполнения запроса */
            $result_executed_query = self::get_result_executed_query('Добавление информации', $distributor_query);

            /* Выдаём результат выполнения запроса */
            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

    /**
     * Вызываем получение информации
     *
     * @param string $table таблица
     * @param array $select взятие
     * @param array $where уточнение
     * @param integer|false $positions_first_row Позиция первой записи
     * @param integer|false $limit Количество записей
     * @param array|false $sort сортировка
     * @param array $values значения
     * @return array|false
     * @throws
     */
    static function call_get_information($table, $select, $where, $sort, $positions_first_row, $limit, $values)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        if (!$select or count($select) == 0){
            return false;
        }

        try {

            /* Корректируем позицию первой записи */
            $positions_first_row = self::correct_limit($positions_first_row, $values);

            /* Формируем запрос */
            $query = self::formation_query_get_information($table,  $select,  $where, $sort, $positions_first_row, $limit);

            /* Значения */
            $values = self::adaptation_value($values, 'values');

            /* Выполняем запрос */
            $distributor_query = self::execute_query($query, $values);

            /* Получаем результат выполнения запроса */
            $result_executed_query = self::get_result_executed_query('Получение информации', $distributor_query, $limit);

            /* Выдаём результат выполнения запроса */
            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

    /**
     * Вызываем количество информации
     *
     * @param string $table таблица
     * @param array $where уточнение
     * @param array $values значения
     * @return integer|false
     * @throws
     */
    static function call_count_information($table, $where, $values)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /* Формируем запрос */
            $query = self::formation_query_count_information($table, $where);

            /* Значения */
            $values = self::adaptation_value($values, 'values');

            /* Выполняем запрос */
            $distributor_query = self::execute_query($query, $values);

            /* Получаем результат выполнения запроса */
            $result_executed_query = self::get_result_executed_query('Количество информации', $distributor_query);

            /* Выдаём результат выполнения запроса */
            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

    /**
     * Вызываем обновление информации
     *
     * @param string $table таблица
     * @param array $set Передачи
     * @param array $where уточнение
     * @param integer|false $limit Количество записей
     * @param array $values значения
     * @return integer|false
     * @throws
     */
    static function call_update_information($table, $set, $where, $limit, $values)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        if (!$set or count($set) == 0){
            return false;
        }

        try {

            /* Формируем запрос */
            $query = self::formation_query_update_information($table, $set, $where, $limit);

            /* Значения */
            $values = self::adaptation_value($values, 'values');

            /* Выполняем запрос */
            $distributor_query = self::execute_query($query, $values);

            /* Получаем результат выполнения запроса */
            $result_executed_query = self::get_result_executed_query('Изменение информации', $distributor_query);

            /* Выдаём результат выполнения запроса */
            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

    /**
     * Вызываем удаление информации
     *
     * @param string $table таблица
     * @param array $where уточнение
     * @param integer|false $limit Количество записей
     * @param array $values значения
     * @return integer|false
     * @throws
     */
    static function call_delete_information($table, $where, $limit, $values)
    {

        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /* Формируем запрос */
            $query = self::formation_query_delete_information($table, $where, $limit);

            /* Значения */
            $values = self::adaptation_value($values, 'values');

            /* Выполняем запрос */
            $distributor_query = self::execute_query($query, $values);

            /* Получаем результат выполнения запроса */
            $result_executed_query = self::get_result_executed_query('Удаление информации', $distributor_query);

            /* Выдаём результат выполнения запроса */
            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

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
    static function call_create_structure_table($table, $intended, $primary_column, $type_primary_column, $default_primary_column, $intended_primary_column){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_create_structure_table($table, $intended, $primary_column, $type_primary_column, $default_primary_column, $intended_primary_column);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

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
    static function call_create_structure_column($table, $column, $type_column, $default_column, $intended_column){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_create_structure_column($table, $column, $type_column, $default_column, $intended_column);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

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
    static function call_create_structure_sorting($table, $index, $unique_sorting, $columns_index){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_create_structure_sorting($table, $index, $unique_sorting, $columns_index);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

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
    static function call_create_structure_reference($table, $column, $default_column, $table_reference, $column_reference, $action_update_column_reference, $action_delete_column_reference){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_create_structure_reference($table, $column, $default_column, $table_reference, $column_reference, $action_update_column_reference, $action_delete_column_reference);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

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
    static function call_delete_structure_reference($table, $column, $table_reference, $column_reference){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_delete_structure_reference($table, $column, $table_reference, $column_reference);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

    /**
     * Вызов удаления Структуры сортировки
     *
     * @param string $table таблица
     * @param string $index индекс
     * @param boolean $unique_sorting уникальность сортировки
     * @return boolean
     * @throws
     */
    static function call_delete_structure_sorting($table, $index, $unique_sorting){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_delete_structure_sorting($table, $index, $unique_sorting);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

    /**
     * Вызов удаление Структуры колонки
     *
     * @param string $table таблица
     * @param string $column колонка
     * @return boolean
     * @throws
     */
    static function call_delete_structure_column($table, $column){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_delete_structure_column($table, $column);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

    /**
     * Вызов удаление Структуры таблицы
     *
     * @param string $table таблица
     * @return boolean
     * @throws
     */
    static function call_delete_structure_table($table){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_delete_structure_table($table);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

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
    static function call_correct_structure_column($table, $column, $type_column, $default_column, $intended_column){


        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            $query = self::formation_query_correct_structure_column($table, $column, $type_column, $default_column, $intended_column);

            /*Выполняем запрос*/
            $result_executed_query = self::send_request_to_data_base($query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

}

?>