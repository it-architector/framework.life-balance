<?php

namespace Framework_life_balance\core_components\their_modules;


/**
 * Модуль базы данных mysql (pdo)
 *
 * @package Framework_life_balance\core_components\their_modules
 *
 */
class Data_Base implements Structure_Data_Base
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

        /*запись взаимодействий с базой данных в файл лога */
        if (self::$file_log!=null){
            file_put_contents(
                self::$file_log,
                '['.date('d-m-y H:i:s').'] '.$query . "\n",
                FILE_APPEND
            );
        }


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
    /*-----------------------КОНТРОЛЬ--------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Фиксируем ошибку
     *
     * @param string $message сообщение
     * @throws \Exception
     */
    static function fix_error($message){
        throw new \Exception($message);
    }

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
    static function formation_query_add_information($table, $set){

        /*запрос*/
        $query = [];

        /*значения запроса*/
        $values_query = [];

        /*таблица*/
        $query[] = 'INSERT INTO '.self::adaptation_value(self::$schema,'`') . '.'. self::adaptation_value($table,'`');

        /*установка*/
        $set_explode=[];

        foreach($set as $num_group_add=>$set_data){

            $set_explode[] = '(' . self::formation_fields_and_manifestation_values_query($values_query, 'code', $set_data, $num_group_add) . ')';

        }

        $query[] = '(' . self::formation_fields_and_manifestation_values_query($values_query, 'key', $set[0]) . ') VALUES '.implode(', ',$set_explode);

        /*результат*/
        return [
            implode(' ',$query),
            $values_query
        ];

    }

    /**
     * формируем запрос на получение информации
     *
     * @param string $table таблица
     * @param array|false $select взятие
     * @param array|false $where уточнение
     * @param array|false $sort сортировка
     * @param array|string|false $limit ограничение
     * @return array
     * @throws
     */
    static function formation_query_get_information($table,  $select,  $where, $sort, $limit){

        /*запрос*/
        $query = [];

        /*значения запроса*/
        $values_query = [];

        /*взятие*/
        $query[] = 'SELECT ' . (($select) ? implode(', ', $select) : '*');

        /*таблица*/
        $query[] = 'FROM '.self::adaptation_value(self::$schema,'`'). '.'. self::adaptation_value($table,'`');

        /*условие*/
        if($where){
            $query[] = 'WHERE ' . self::formation_fields_and_manifestation_values_query($values_query, 'where', $where);
        }

        /*сортировка*/
        if($sort){

            $sort_explode = [];

            foreach($sort as $sort_key => $sort_value){
                $sort_explode[] = self::adaptation_value($table,'`') . '.' . $sort_key . ' ' . $sort_value;
            }

            $query[] = 'ORDER BY ' . implode(',',$sort_explode);

        }

        /*ограничение*/
        if($limit) {
            if(is_integer($limit)){
                $query[] = 'LIMIT ' . $limit;
            }
            elseif(is_array($limit) and count($limit)==2){
                $query[] = 'LIMIT ' . $limit[0].','.$limit[1];
            }
        }

        /*результат*/
        return [
            implode(' ',$query),
            $values_query
        ];

    }

    /**
     * формируем запрос на количество информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @return array
     * @throws
     */
    static function formation_query_count_information($table, $where){

        /*запрос*/
        $query = [];

        /*значения запроса*/
        $values_query = [];

        /*взятие*/
        $query[] = 'SELECT count(*) as count';

        /*таблица*/
        $query[] = 'FROM '. self::adaptation_value(self::$schema,'`') . '.' . self::adaptation_value($table,'`');

        /*условие*/
        if($where){
            $query[] = 'WHERE ' . self::formation_fields_and_manifestation_values_query($values_query, 'where', $where);
        }

        /*ограничение*/
        $query[] = 'LIMIT 1';

        /*результат*/
        return [
            implode(' ', $query),
            $values_query
        ];

    }

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
    static function formation_query_update_information($table, $set, $where, $limit){

        /*запрос*/
        $query = [];

        /*значения запроса*/
        $values_query = [];

        /*таблица*/
        $query[] = 'UPDATE '. self::adaptation_value(self::$schema,'`') . '.' . self::adaptation_value($table,'`');

        /*установка*/
        if($set){
            $query[] = 'SET ' . self::formation_fields_and_manifestation_values_query($values_query, 'set', $set);
        }

        /*условие*/
        if($where){
            $query[] = 'WHERE ' . self::formation_fields_and_manifestation_values_query($values_query, 'where', $where);
        }

        /*ограничение*/
        if($limit) {
            if(is_integer($limit)){
                $query[] = 'LIMIT ' . $limit;
            }
            elseif(is_array($limit) and count($limit)==2){
                $query[] = 'LIMIT ' . $limit[0].','.$limit[1];
            }
        }

        /*результат*/
        return [
            implode(' ', $query),
            $values_query
        ];

    }

    /**
     * формируем запрос на удаление информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @param array|string|false $limit ограничение
     * @return array
     * @throws
     */
    static function formation_query_delete_information($table, $where, $limit){

        /*запрос*/
        $query = [];

        /*значения запроса*/
        $values_query = [];

        /*таблица*/
        $query[] = 'DELETE FROM ' . self::adaptation_value(self::$schema,'`') . '.' . self::adaptation_value($table,'`');

        /*условие*/
        if($where){
            $query[] = 'WHERE ' . self::formation_fields_and_manifestation_values_query($values_query, 'where', $where);
        }

        /*ограничение*/
        if($limit) {
            if(is_integer($limit)){
                $query[] = 'LIMIT ' . $limit;
            }
            elseif(is_array($limit) and count($limit)==2){
                $query[] = 'LIMIT ' . $limit[0].','.$limit[1];
            }
        }

        /*результат*/
        return [
            implode(' ', $query),
            $values_query
        ];

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
     * @param string $string значение
     * @param string|false $limiter ограничения
     * @return string $string экранизированное значение
     */
    static function adaptation_value($string, $limiter = false)
    {

        if($limiter){
            $string = $limiter.$string.$limiter;
        }
        else{

            if (!is_null(self::$link_communication_with_data_base)) {
                if (is_array($string)) {
                    foreach ($string as $k => $v) {
                        $string[$k] = self::adaptation_value($v);
                    }
                } else {
                    $string = self::$link_communication_with_data_base->quote($string);
                }
            }

        }
        return $string;
    }

    /**
     * Формируем поля и проявляем значения запроса
     *
     * @param array $values_query все значения ключей
     * @param string $format формат
     * @param array $values значения
     * @param integer|false $num_group_add номер группы добавления
     * @return string
     */
    static function formation_fields_and_manifestation_values_query(&$values_query, $format, $values,  $num_group_add = false)
    {

        /*объединители*/
        $combiners = [
            'key'   => ', ',
            'code'  => ', ',
            'set'   => ', ',
            'where' => ' ',
        ];

        /*поля*/
        $fields = [];

        if($values){
            foreach ($values as $key => $value) {

                /*для условия ключ находится в $value*/
                if($format == 'where'){
                    if(is_array($value)){
                        $key_value = $value;
                        $key = key($key_value);
                        $value = $key_value[$key];
                    }
                    /*если просто текст, то это внутренние объединители*/
                    else{
                        $fields[] = $value;
                        continue;
                    }
                }

                /*код*/
                $code= ':' . $key.(($num_group_add!==false)?'_'.$num_group_add:'');

                /*ключ*/
                $key = self::adaptation_value($key,'`');

                /*формируем поля*/
                switch ($format) {
                    case 'key'  :
                        $fields[] = $key;
                        break;
                    case 'code' :
                        $fields[] = $code;
                        break;
                    case 'set'  :
                        $fields[] = $key . ' = ' . $code;
                        break;
                    case 'where':
                        if(is_array($value)){
                            if(count($value) == 2){
                                $fields[] = $key . ' ' . $value[0] . $code;
                            }
                            elseif(count($value) == 4){
                                $fields[] = $key . ' ' . $value[0] . ' ' . $value[1] . $code . $value[3];
                            }
                        }
                        else{
                            $fields[] = $key . ' = ' . $code;
                        }
                        break;
                }

                /*выявляем значения запроса*/
                switch ($format) {
                    case 'code' :
                    case 'set'  :
                    $values_query[$code] = $value;
                    break;
                    case 'where':
                        if (is_array($value)){
                            if(count($value) == 2){
                                $values_query[$code] = $value[1];
                            }
                            elseif(count($value) == 4){
                                $values_query[$code] = $value[2];
                            }
                        }
                        else{
                            $values_query[$code] = $value;
                        }
                        break;
                }

            }
        }

        /*отдаём поля*/
        return count($fields) > 0 ? implode($combiners[$format], $fields) : '';
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
     * @param array|string|false $limit ограничение
     * @return array|false
     */
    static function get_result_executed_query($type_query, $distributor_query, $limit = false)
    {

        /*выдаём результат*/
        switch ($type_query) {
            case 'group_add_information' :
            case 'add_information'       :
                return self::get_last_auto_increment_id();
                break;
            case 'get_information'       :
                if (self::get_count_rows($distributor_query) == 0){
                    return false;
                }
                elseif ($limit and $limit == 1){
                    return self::get_rows($distributor_query);
                }
                else{
                    $rows = [];
                    while ($row = self::get_rows($distributor_query)) {
                        $rows[] = $row;
                    }
                    return $rows;
                }
                break;
            case 'count_information'     :
                if (self::get_count_rows($distributor_query) == 0){
                    return false;
                }
                $row = self::get_rows($distributor_query);
                return $row['count'];
                break;
            case 'update_information'    :
            case 'delete_information'    :
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

        /*запись взаимодействий с базой данных в файл лога */
        if (self::$file_log!=null){
            file_put_contents(
                self::$file_log,
                '['.date('d-m-y H:i:s').'] '.$query . ' | values: ' . json_encode($values). "\n",
                FILE_APPEND
            );
        }

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
    static function call_add_information($table, $set = false)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        if (!$set){
            return false;
        }

        try {

            /*Формируем запрос*/
            list($query,$values_query) = self::formation_query_add_information($table,  [0=>$set]);

            /*Выполняем запрос*/
            $distributor_query = self::execute_query($query, $values_query);

            /*Получаем результат выполнения запроса*/
            $result_executed_query = self::get_result_executed_query('add_information', $distributor_query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

    /**
     * Вызываем групповое добавление информации
     *
     * @param string $table таблица
     * @param array|false $set установка
     * @return integer|false
     * @throws
     */
    static function call_group_add_information($table, $set = false)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        if (!$set and count($set)==0){
            return false;
        }

        try {

            /*Формируем запрос*/
            list($query,$values_query) = self::formation_query_add_information($table, $set);

            /*Выполняем запрос*/
            $distributor_query = self::execute_query($query, $values_query);

            /*Получаем результат выполнения запроса*/
            $result_executed_query = self::get_result_executed_query('group_add_information', $distributor_query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

    /**
     * Вызываем получение информации
     *
     * @param string $table таблица
     * @param array|false $select взятие
     * @param array|false $where уточнение
     * @param array|false $limit ограничение
     * @param array|false $sort сортировка
     * @return array|false
     * @throws
     */
    static function call_get_information($table, $select, $where = false, $sort = false, $limit = false)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            list($query,$values_query) = self::formation_query_get_information($table,  $select,  $where, $sort, $limit);

            /*Выполняем запрос*/
            $distributor_query = self::execute_query($query, $values_query);

            /*Получаем результат выполнения запроса*/
            $result_executed_query = self::get_result_executed_query('get_information', $distributor_query, $limit);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

    /**
     * Вызываем количество информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @return integer|false
     * @throws
     */
    static function call_count_information($table, $where = false)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            list($query, $values_query) = self::formation_query_count_information($table, $where);

            /*Выполняем запрос*/
            $distributor_query = self::execute_query($query, $values_query);

            /*Получаем результат выполнения запроса*/
            $result_executed_query = self::get_result_executed_query('count_information', $distributor_query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }
    }

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
    static function call_update_information($table, $set = false, $where = false, $limit = false)
    {
        if(self::$link_communication_with_data_base==null){
            return false;
        }

        if (!$set){
            return false;
        }

        try {

            /*Формируем запрос*/
            list($query,$values_query) = self::formation_query_update_information($table, $set, $where, $limit);

            /*Выполняем запрос*/
            $distributor_query = self::execute_query($query, $values_query);

            /*Получаем результат выполнения запроса*/
            $result_executed_query = self::get_result_executed_query('update_information', $distributor_query);

            return $result_executed_query;

        } catch (\PDOException $e) {
            self::fix_error($e->getMessage());
        }

    }

    /**
     * Вызываем удаление информации
     *
     * @param string $table таблица
     * @param array|false $where уточнение
     * @param array|false $limit ограничение
     * @return integer|false
     * @throws
     */
    static function call_delete_information($table, $where = false, $limit = false)
    {

        if(self::$link_communication_with_data_base==null){
            return false;
        }

        try {

            /*Формируем запрос*/
            list($query,$values_query) = self::formation_query_delete_information($table, $where, $limit);

            /*Выполняем запрос*/
            $distributor_query = self::execute_query($query, $values_query);

            /*Получаем результат выполнения запроса*/
            $result_executed_query = self::get_result_executed_query('delete_information', $distributor_query);

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