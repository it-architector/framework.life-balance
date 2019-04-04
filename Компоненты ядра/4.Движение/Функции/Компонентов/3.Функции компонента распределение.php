<?php

namespace Framework_life_balance\core_components;

use \Framework_life_balance\core_components\Conditions;
use \Framework_life_balance\core_components\Orientation;
use \Framework_life_balance\core_components\Motion;

use \Framework_life_balance\core_components\their_modules\Data_Base;
use \PHPMailer\PHPMailer\PHPMailer;

/**
 * Суть распределения
 *
 * @package Framework_life_balance\core_components
 *
 */
class Distribution
{

    /**
     * Подготавливаем работу с ресурсами
     *
     * @return null
     */
    static function initiation()
    {

        /* Получаем настройки коммуникаций из файла */
        $config_communications = Distribution::include_information_from_file(DIR_RESOURCES,'Настройка коммуникаций','php');

        if($config_communications === null){
            Motion::fix_error('нет файла настройки коммуникаций',__FILE__,__LINE__);
        }

        /* Устанавливаем настройки коммуникаций */
        Conditions::set_mission('config_communications',$config_communications);

        /* Получаем схему наработок из файла */
        $schema_experiences = Distribution::include_information_from_file(DIR_MEASURES_FUNCTIONS,'Норматив функций сайта','php');

        if($schema_experiences === null){
            Motion::fix_error('нет файла норматива функций сайта',__FILE__,__LINE__);
        }

        /* Устанавливаем схему наработок */
        Conditions::set_mission('schema_experiences',$schema_experiences);

        /* Получаем схему базы данных из файла */
        $schema_data_base = Distribution::include_information_from_file(DIR_MEASURES_DATA_BASE,'Норматив таблиц базы данных','php');

        if($schema_data_base === null){
            Motion::fix_error('нет файла норматива таблиц базы данных',__FILE__,__LINE__);
        }

        /* Устанавливаем схему базы данных */
        Conditions::set_mission('schema_data_base',$schema_data_base);

        /* Получаем схему взаимодействия с базой данных */
        $schema_interaction_with_data_base = Distribution::include_information_from_file(DIR_MEASURES_DATA_BASE,'Норматив взаимодействия с базой данных','php');

        if($schema_interaction_with_data_base === null){
            Motion::fix_error('нет файла норматива взаимодействия с базой данных',__FILE__,__LINE__);
        }

        /* Устанавливаем схему взаимодействия с базой данных */
        Conditions::set_mission('schema_interaction_with_data_base', $schema_interaction_with_data_base);

    }

    /*---------------------------------------------------------*/
    /*-----------------------Нормативы-------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Норматив функций сайта
     *
     * @param string $experience наработка
     * @param string $goal цель
     * @param string $detail деталь
     * @return array|boolean
     */
    static function schema_experience($experience = null, $goal = null, $detail = null)
    {

        /*Проверяем правильное взятие норматива наработок*/
        Orientation::check_correct_taking_schema_experience($experience, $goal, $detail);

        /*получаем схему наработок*/
        $schema_experiences = Conditions::get_mission('schema_experiences');

        /*получаем данные на цель*/
        if($experience!== null and $goal !== null){

            if($detail !== null){
                return $schema_experiences[$experience]['goals'][$goal][$detail];
            }
            else{
                return $schema_experiences[$experience]['goals'][$goal];
            }
        }
        /*получаем данные на наработку*/
        elseif($experience !== null){

            if($detail !== null){
                return $schema_experiences[$experience][$detail];
            }
            else{
                return $schema_experiences[$experience];
            }
        }
        /*выдаём всё*/
        else{
            return $schema_experiences;
        }

    }

    /**
     * Норматив таблиц базы данных
     *
     * @param string $table показать данные определенной таблицы
     * @param string $column показать данные определенной колонки
     * @param string $detail деталь
     * @return array|boolean
     */
    static function schema_data_base($table = null, $column = null, $detail = null)
    {

        /*Проверяем правильное взятие норматива базы данных*/
        Orientation::check_correct_taking_schema_data_base($table, $column, $detail);

        /*получаем схему базы данных*/
        $schema_data_base = Conditions::get_mission('schema_data_base');

        /*получаем данные на цель*/
        if($table!=null and $column!=null){

            if($detail != null){
                return $schema_data_base[$table]['columns'][$column][$detail];
            }
            else{
                return $schema_data_base[$table]['columns'][$column];
            }
        }
        /*получаем данные на наработку*/
        elseif($table!=null){

            if($detail != null){
                return $schema_data_base[$table][$detail];
            }
            else{
                return $schema_data_base[$table];
            }
        }
        /*выдаём всё*/
        else{
            return $schema_data_base;
        }

    }

    /**
     * Сохраняем реализованную схему базы данных
     *
     * @param array $realized_schema реализованная схема
     */
    static function save_realized_schema_data_base($realized_schema){

        self::write_information_in_file(DIR_MEASURES_DATA_BASE,'Реализованный норматив таблиц базы данных','php', '<?php'."\n".' return '.var_export($realized_schema, true).'; ?>');

    }

    /**
     * Получаем информацию реализованной норматива базы данных
     *
     * @return array $realized_schema
     */
    static function get_information_realized_schema_data_base(){

        $realized_schema = self::include_information_from_file(DIR_MEASURES_DATA_BASE,'Реализованный норматив таблиц базы данных','php');

        return is_array($realized_schema) ? $realized_schema : [];

    }

    /*---------------------------------------------------------*/
    /*---------------------КОММУНИКАЦИИ------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Создаем коммуникацию с базой данных
     *
     * @return boolean
     */
    static function create_communication_with_data_base(){

        /*получаем настройки системы*/
        $config_system = Conditions::get_mission('config_system');

        /*включено ли*/
        if(!$config_system['inclusiveness_data_base']){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            /*фиксируем ошибку*/
            Motion::fix_error('no class Data_Base',__FILE__,__LINE__);
        }

        /*получаем настройки ппроекта*/
        $config_project = Conditions::get_mission('config_project');

        /*получаем настройки коммуникаций*/
        $config_communications = Conditions::get_mission('config_communications');

        try{

            /*получаем настройки протоколов*/
            $config_protocols = Conditions::get_mission('config_protocols');

            /*запись взаимодействий с базой данных в файл лога */
            if($config_protocols['Запросы в базу данных']){
                $file_log = DIR_PROTOCOLS_PROCESSES . 'Запросы в базу данных.log';
            }
            else{
                $file_log = null;
            }

            /*подключаемся к базе данных*/
            Data_Base::create_communication_with_data_base(
                $config_communications['data_base']['host'],
                $config_communications['data_base']['name'],
                $config_communications['data_base']['schema'],
                $config_project['access_data_base']['user'],
                $config_project['access_data_base']['password'],
                $file_log
            );

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Motion::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Завершаем коммуникацию с базой данных
     *
     * @return boolean
     */
    static function complete_communication_with_data_base(){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        try{
            /*Завершаем коммуникацию с базой данных*/
            $result = Data_Base::complete_communication_with_data_base();

            return $result;
        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Motion::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Создаем коммуникацию с памятью
     *
     * @return boolean
     */
    static function create_communication_with_memory(){

        /*получаем настройки системы*/
        $config_system = Conditions::get_mission('config_system');

        /*включено ли*/
        if(!$config_system['inclusiveness_memory']){
            return false;
        }

        /*получаем настройки коммуникации*/
        $config_communications = Conditions::get_mission('config_communications');

        /*есть ли настройки*/
        if(!isset($config_communications['memory'])){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('Memcache')){
            /*фиксируем ошибку*/
            Motion::fix_error('no install/start memcache',__FILE__,__LINE__);
        }

        try{

            $link_communication_with_memory = \memcache_connect(
                $config_communications['memory']['host'],
                $config_communications['memory']['port']
            );

            /*устанавливаем ссылку на коммуникацию с памятью*/
            Conditions::set_mission('link_communication_with_memory',$link_communication_with_memory);

        }catch ( \Exception $e ) {
            /*фиксируем ошибку*/
            Motion::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Завершаем коммуникацию с памятью
     *
     * @return boolean
     */
    static function complete_communication_with_memory(){

        /*получаем ссылку на коммуникацию с памятью*/
        $link_communication_with_memory = Conditions::get_mission('link_communication_with_memory');

        if($link_communication_with_memory == null){
            return false;
        }

        \memcache_close($link_communication_with_memory);

        /*Обнуляем ссылку на коммуникацию с памятью*/
        Conditions::delete_mission('link_communication_with_memory');

        return true;

    }

    /**
     * Создаем коммуникацию с почтой
     *
     * @return boolean
     */
    static function create_communication_with_mail(){

        /*получаем настройки системы*/
        $config_system = Conditions::get_mission('config_system');

        /*включено ли*/
        if(!$config_system['inclusiveness_mail']){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('\PHPMailer\PHPMailer\PHPMailer')){
            /*фиксируем ошибку*/
            Motion::fix_error('no class PHPMailer',__FILE__,__LINE__);
        }

        /*получаем настройки ппроекта*/
        $config_project = Conditions::get_mission('config_project');

        /*получаем настройки коммуникации*/
        $config_communications = Conditions::get_mission('config_communications');

        try {


            $mail = new PHPMailer(true);

            /*настраиваем*/
            $mail->SMTPDebug = 0;
            $mail->CharSet = "UTF-8";
            $mail->Timeout = 3;
            $mail->isSMTP();
            $mail->Host = $config_communications['mail']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config_project['access_mail']['login'];
            $mail->Password = $config_project['access_mail']['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $config_communications['mail']['port'];

            /*для портов 587 настройка работы с сертификатом*/
            if($config_communications['mail']['port']==587){
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }
            /*получаем настройки проекта*/
            $config_project = Conditions::get_mission('config_project');

            /*от кого письмо*/
            $mail->setFrom($config_project['email'], $config_project['name']);

            /*устанавливаем ссылку на коммуникацию с почтой*/
            Conditions::set_mission('link_communication_with_mail',$mail);

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /*фиксируем ошибку*/
            Motion::fix_error($mail->ErrorInfo,__FILE__,__LINE__);
        }

    }

    /**
     * Завершаем коммуникацию с почтой
     *
     * @return boolean
     */
    static function complete_communication_with_mail(){

        /*получаем ссылку на коммуникацию с почтой*/
        $link_communication_with_mail = Conditions::get_mission('link_communication_with_mail');

        if($link_communication_with_mail == null){
            return false;
        }

        /*Обнуляем ссылку на коммуникацию с почтой*/
        Conditions::delete_mission('link_communication_with_mail');

        return true;

    }

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
    static function write_information_in_file($dir, $name, $type, $information){

        if($type == 'log'){
            $information = '['.Orientation::position_time().'] ' . $information . "\r\n";
            /*дозапись*/
            $addition = true;
        }
        elseif($type == 'md'){
                /*дозапись*/
                $addition = true;
            }
        else{
            /*дозапись*/
            $addition = false;
        }

        file_put_contents(
            $dir . $name . '.' . $type,
            $information,
            $addition ? FILE_APPEND : null
        );
    }

    /**
     * Подключаем информацию из файла
     *
     * @param string $dir папка
     * @param string $name название файла
     * @param string $type тип файла
     * @return array|string|boolean
     */
    static function include_information_from_file($dir, $name, $type){

        /*путь к файлу*/
        $patch_file =  $dir . $name . '.'.$type;

        /*проверяем файл*/
        if (!file_exists($patch_file)) {
            return null;
        }

        if($type == 'php'){

            /*подлючаем файл*/
            return include $patch_file;

        }
        elseif($type == 'log'){

            /*читаем файл*/
            return file($patch_file);

        }
        elseif($type == 'html'){

            /*читаем файл*/
            return file_get_contents($patch_file);

        }
        else{
            return null;
        }

    }

    /**
     * Удаляем файл
     *
     * @param string $dir папка
     * @param string $name название файла
     * @param string $type тип файла
     * @return null
     */
    static function delete_file($dir,$name,$type){

        /*путь к файлу*/
        $patch_file =  $dir . $name . '.'.$type;

        /*проверяем наличие файла*/
        if (!file_exists($patch_file)) {
            return false;
        }

        /*удаляем файл*/
        unlink($patch_file);

    }

    /*------БАЗА ДАННЫХ------*/

    /**
     * Взаимообмен информацией с базой данных
     *
     * @param string $direction направление
     * @param string $what чего
     * @param array $values значения
     * @return mixed
     */
    static function interchange_information_with_data_base($direction, $what, $values){

        /* Получаем схему взаимодействия с базой данных */
        $schema_interaction_with_data_base = Conditions::get_mission('schema_interaction_with_data_base');

        if($schema_interaction_with_data_base == null){
            return false;
        }

        if(!isset($schema_interaction_with_data_base[$direction])){
            /* Фиксируем ошибку */
            Motion::fix_error('Не известно направление "'.$direction.'" во взаимодействии с базой данных', __FILE__, __LINE__);
        }
        elseif(!isset($schema_interaction_with_data_base[$direction][$what])){
            /* Фиксируем ошибку */
            Motion::fix_error('Не известно чего "'.$what.'" направления "'.$direction.'" во взаимодействии с базой данных', __FILE__, __LINE__);
        }

        /* Информация запроса */
        $information_query = $schema_interaction_with_data_base[$direction][$what];

        try{

            if($direction == 'Добавление'){

                $key = Data_Base::call_add_information(
                    $information_query['Таблица'],
                    $information_query['Передачи'],
                    $values
                );

                return $key;

            }
            elseif($direction == 'Количество'){

                $count = Data_Base::call_count_information(
                    $information_query['Таблица'],
                    $information_query['Уточнение'],
                    $values
                );

                return $count;

            }
            elseif($direction == 'Получение'){

                $data = Data_Base::call_get_information(
                    $information_query['Таблица'],
                    $information_query['Получение'],
                    $information_query['Уточнение'],
                    $information_query['Сортировка'],
                    $information_query['Позиция'],
                    $information_query['Количество'],
                    $values
                );

                return $data;

            }
            elseif($direction == 'Изменение'){

                $updated = Data_Base::call_update_information(
                    $information_query['Таблица'],
                    $information_query['Передачи'],
                    $information_query['Уточнение'],
                    $information_query['Количество'],
                    $values
                );

                return $updated;

            }
            elseif($direction == 'Удаление'){

                $deleted = Data_Base::call_delete_information(
                    $information_query['Таблица'],
                    $information_query['Уточнение'],
                    $information_query['Количество'],
                    $values
                );

                return $deleted;

            }
            else{
                /* Фиксируем ошибку */
                Motion::fix_error('Не известно направление "'.$direction.'" во взаимодействии с базой данных', __FILE__, __LINE__);
            }

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Motion::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Реконструируем базу данных
     *
     * @param array $changes изменения
     * @return boolean
     */
    static function reconstruction_data_base($changes){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*инструкция когда случилась ошибка*/
        $instruction_when_error = '<br><br>Когда поправите код, вручную запустите в консоли команду: php Ядро.php control reassembly_data_base';

        /*последовательность применения изменений*/
        $sequence_changes = [
            'delete_reference',
            'delete_sortings',
            'delete_column',
            'delete_table',

            'correct_comment_table',
            'correct_primary_column_table',
            'correct_column',

            'create_table',
            'create_column',
            'create_sortings',
            'create_reference',
        ];

        /* Реализованный норматив таблиц базы данных */
        $realized_schema = Distribution::get_information_realized_schema_data_base();

        try{

            foreach($sequence_changes as $change){
                if(isset($changes[$change]) and count($changes[$change])>0){

                    if($change == 'create_table'){

                        foreach($changes[$change] as $table => $table_change){

                            /*Вызываем создание Структуры таблицы*/
                            Data_Base::call_create_structure_table(
                                $table,
                                $table_change['description'],
                                $table_change['primary_column'],
                                $table_change['primary_column_data']['type'],
                                $table_change['primary_column_data']['default'],
                                $table_change['primary_column_data']['description']
                            );

                            /*заполняем реализованное*/
                            $realized_schema[$table]['description'] = $table_change['description'];
                            $realized_schema[$table]['primary_column'] = $table_change['primary_column'];
                            $realized_schema[$table]['columns'][$table_change['primary_column']] = [
                                'type'        => $table_change['primary_column_data']['type'],
                                'default'     => $table_change['primary_column_data']['default'],
                                'description' => $table_change['primary_column_data']['description'],
                            ];

                            /*сохраняем схему реализованного*/
                            self::save_realized_schema_data_base($realized_schema);

                            /* Фиксируем реконструкцию базы данных */
                            Motion::fix_reassembly_data_base('Создана таблица '.$table);

                        }

                    }
                    elseif($change == 'create_column'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $column_change){

                                /*Вызываем создание Структуры колонки*/
                                Data_Base::call_create_structure_column(
                                    $table,
                                    $column,
                                    $column_change['type'],
                                    $column_change['default'],
                                    $column_change['description']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['columns'][$column] = [
                                    'description' => $column_change['description'],
                                    'type'    => $column_change['type'],
                                    'default' => $column_change['default'],
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Создана колонка '.$column.' в таблице '.$table);

                            }
                        }
                    }
                    elseif($change == 'create_sortings'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $sorting => $sorting_change){

                                /*Вызываем создание Структуры сортировки*/
                                Data_Base::call_create_structure_sorting(
                                    $table,
                                    $sorting,
                                    $sorting_change['unique'],
                                    $sorting_change['columns']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['sortings'][$sorting] = [
                                    'description' => $sorting_change['description'],
                                    'unique'   => $sorting_change['unique'],
                                    'columns'  => $sorting_change['columns']
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Создана сортировка '.$sorting.' в таблице '.$table);

                            }
                        }
                    }
                    elseif($change == 'create_reference'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $reference_change){

                                /*проверяем соотвествие типов колонок*/
                                if($realized_schema[$table]['columns'][$column]['type'] != $realized_schema[$reference_change['table']]['columns'][$reference_change['column']]['type']){
                                    Motion::fix_error('нет возможности создать связь у колонок '.$table.'.'.$column.' ('.$realized_schema[$table]['columns'][$column]['type'].') и '.$reference_change['table'].'.'.$reference_change['column'].' ('.$realized_schema[$reference_change['table']]['columns'][$reference_change['column']]['type'].') по причине разных типов колонок' . $instruction_when_error,__FILE__,__LINE__);
                                }

                                /*Вызываем создание Структуры связи*/
                                Data_Base::call_create_structure_reference(
                                    $table,
                                    $column,
                                    $realized_schema[$table]['columns'][$column]['default'],
                                    $reference_change['table'],
                                    $reference_change['column'],
                                    $reference_change['update'],
                                    $reference_change['delete']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['references'][$column] = [
                                    'table'  => $reference_change['table'],
                                    'column' => $reference_change['column'],
                                    'update' => $reference_change['update'],
                                    'delete' => $reference_change['delete']
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Создана связь колонке '.$column.' в таблице '.$table);

                            }
                        }

                    }
                    elseif($change == 'delete_reference'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $reference_change){

                                /*Вызываем удаления Структуры связи*/
                                Data_Base::call_delete_structure_reference(
                                    $table,
                                    $column,
                                    $reference_change['table'],
                                    $reference_change['column']
                                );

                                /*удаляем из реализованного*/
                                unset($realized_schema[$table]['references'][$column]);

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Удалена связь колонке '.$column.' в таблице '.$table);

                            }
                        }

                    }
                    elseif($change == 'delete_sortings'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $sorting => $sorting_change){

                                /*Вызываем удаление Структуры сортировки*/
                                Data_Base::call_delete_structure_sorting(
                                    $table,
                                    $sorting,
                                    $sorting_change['unique']
                                );

                                /*удаляем из реализованного*/
                                unset($realized_schema[$table]['sortings'][$sorting]);

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Удалена сортировка '.$sorting.' в таблице '.$table);

                            }
                        }

                    }
                    elseif($change == 'delete_column'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $column_change){

                                /*Вызываем удаления Структуры колонки*/
                                Data_Base::call_delete_structure_column(
                                    $table,
                                    $column
                                );

                                /*удаляем из реализованного*/
                                unset($realized_schema[$table]['columns'][$column]);

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Удалена колонка '.$column.' в таблице '.$table);

                            }
                        }

                    }
                    elseif($change == 'delete_table'){

                        foreach($changes[$change] as $table => $table_change){

                            /*Вызываем удаления Структуры таблицы*/
                            Data_Base::call_delete_structure_table(
                                $table
                            );

                            /*удаляем из реализованного*/
                            unset($realized_schema[$table]);

                            /*сохраняем схему реализованного*/
                            self::save_realized_schema_data_base($realized_schema);

                            /* Фиксируем реконструкцию базы данных */
                            Motion::fix_reassembly_data_base('Удалена таблица '.$table);

                        }

                    }
                    elseif($change == 'correct_comment_table'){
                        Motion::fix_error('correct_comment_table не реализовано' . $instruction_when_error,__FILE__, __LINE__);
                    }
                    elseif($change == 'correct_primary_column_table'){
                        Motion::fix_error('correct_primary_column_table не реализовано' . $instruction_when_error,__FILE__, __LINE__);
                    }
                    elseif($change == 'correct_column'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $column_change){

                                /*Вызываем изменение Структуры колонки*/
                                Data_Base::call_correct_structure_column(
                                    $table,
                                    $column,
                                    $column_change['type'],
                                    $column_change['default'],
                                    $column_change['description']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['columns'][$column] = [
                                    'type'    => $column_change['type'],
                                    'default' => $column_change['default'],
                                    'description' => $column_change['description'],
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base($realized_schema);

                                /* Фиксируем реконструкцию базы данных */
                                Motion::fix_reassembly_data_base('Изменена колонка '.$column.' в таблице '.$table);

                            }
                        }
                    }
                    else{
                        Motion::fix_error('no '.$change . $instruction_when_error,__FILE__, __LINE__);
                    }
                }

            }

            return true;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Motion::fix_error($e->getMessage() . $instruction_when_error,__FILE__,__LINE__);
        }

    }
}

?>