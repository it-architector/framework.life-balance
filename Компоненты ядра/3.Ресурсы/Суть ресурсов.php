<?php

namespace Framework_life_balance\core_components;

use \Framework_life_balance\core_components\Notices;
use \Framework_life_balance\core_components\Solutions;
use \Framework_life_balance\core_components\Business;

use \Framework_life_balance\core_components\their_modules\Data_Base;
use \PHPMailer\PHPMailer\PHPMailer;

/**
 * Суть ресурсов
 *
 * @package Framework_life_balance\core_components
 *
 */
class Resources implements Structure_Resources
{

    /**
     * Подготавливаем работу с ресурсами
     *
     * @return null
     */
    static function initiation()
    {

        /*получаем настройки коммуникаций из файла*/
        $config_communications = Resources::include_information_from_file(DIR_RESOURCES,'Настройка коммуникаций','php');

        if($config_communications === null){
            Business::fix_error('нет файла настройки коммуникаций',__FILE__,__LINE__);
        }

        /*устанавливаем настройки коммуникаций*/
        Notices::set_mission('config_communications',$config_communications);

        /*получаем схему наработок из файла*/
        $schema_experiences = Resources::include_information_from_file(DIR_SCHEMES,'Схема наработок','php');

        if($schema_experiences === null){
            Business::fix_error('нет файла схема наработок',__FILE__,__LINE__);
        }

        /*устанавливаем схему наработок*/
        Notices::set_mission('schema_experiences',$schema_experiences);

        /*получаем схему базы данных из файла*/
        $schema_data_base = Resources::include_information_from_file(DIR_SCHEMES,'Схема базы данных','php');

        if($schema_data_base === null){
            Business::fix_error('нет файла схема базы данных',__FILE__,__LINE__);
        }

        /*устанавливаем схему базы данных*/
        Notices::set_mission('schema_data_base',$schema_data_base);

    }

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
    static function schema_experience($experience = null, $goal = null, $detail = null)
    {

        /*Проверяем правильное взятие Схемы наработок*/
        Solutions::check_correct_taking_schema_experience($experience, $goal, $detail);

        /*получаем схему наработок*/
        $schema_experiences = Notices::get_mission('schema_experiences');

        /*получаем данные на цель*/
        if($experience!=null and $goal!=null){

            if($detail != null){
                return $schema_experiences[$experience]['goals'][$goal][$detail];
            }
            else{
                return $schema_experiences[$experience]['goals'][$goal];
            }
        }
        /*получаем данные на наработку*/
        elseif($experience!=null){

            if($detail != null){
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
     * Схема базы данных
     *
     * @param string $table показать данные определенной таблицы
     * @param string $column показать данные определенной колонки
     * @param string $detail деталь
     * @return array|boolean
     */
    static function schema_data_base($table = null, $column = null, $detail = null)
    {

        /*Проверяем правильное взятие Схемы базы данных*/
        Solutions::check_correct_taking_schema_data_base($table, $column, $detail);

        /*получаем схему базы данных*/
        $schema_data_base = Notices::get_mission('schema_data_base');

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

        self::write_information_in_file(DIR_SCHEMES,'Реализованная схема базы данных','php', '<?php'."\n".' return '.var_export($realized_schema, true).'; ?>');

    }

    /**
     * Получаем информацию реализованной Схемы базы данных
     *
     * @return array $realized_schema
     */
    static function get_information_realized_schema_data_base(){

        $realized_schema = self::include_information_from_file(DIR_SCHEMES,'Реализованная схема базы данных','php');

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
        $config_system = Notices::get_mission('config_system');

        /*включено ли*/
        if(!$config_system['inclusiveness_data_base']){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            /*фиксируем ошибку*/
            Business::fix_error('no class Data_Base',__FILE__,__LINE__);
        }

        /*получаем настройки ппроекта*/
        $config_project = Notices::get_mission('config_project');

        /*получаем настройки коммуникаций*/
        $config_communications = Notices::get_mission('config_communications');

        try{

            /*получаем настройки протоколов*/
            $config_protocols = Notices::get_mission('config_protocols');

            /*запись взаимодействий с базой данных в файл лога */
            if($config_protocols['queryes_data_base']){
                $file_log = DIR_PROTOCOLS . 'Запросы в базу данных.log';
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
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
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
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Создаем коммуникацию с памятью
     *
     * @return boolean
     */
    static function create_communication_with_memory(){

        /*получаем настройки системы*/
        $config_system = Notices::get_mission('config_system');

        /*включено ли*/
        if(!$config_system['inclusiveness_memory']){
            return false;
        }

        /*получаем настройки коммуникации*/
        $config_communications = Notices::get_mission('config_communications');

        /*есть ли настройки*/
        if(!isset($config_communications['memory'])){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('Memcache')){
            /*фиксируем ошибку*/
            Business::fix_error('no install/start memcache',__FILE__,__LINE__);
        }

        try{

            $link_communication_with_memory = \memcache_connect(
                $config_communications['memory']['host'],
                $config_communications['memory']['port']
            );

            /*устанавливаем ссылку на коммуникацию с памятью*/
            Notices::set_mission('link_communication_with_memory',$link_communication_with_memory);

        }catch ( \Exception $e ) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Завершаем коммуникацию с памятью
     *
     * @return boolean
     */
    static function complete_communication_with_memory(){

        /*получаем ссылку на коммуникацию с памятью*/
        $link_communication_with_memory = Notices::get_mission('link_communication_with_memory');

        if($link_communication_with_memory == null){
            return false;
        }

        \memcache_close($link_communication_with_memory);

        /*Обнуляем ссылку на коммуникацию с памятью*/
        Notices::delete_mission('link_communication_with_memory');

        return true;

    }

    /**
     * Создаем коммуникацию с почтой
     *
     * @return boolean
     */
    static function create_communication_with_mail(){

        /*получаем настройки системы*/
        $config_system = Notices::get_mission('config_system');

        /*включено ли*/
        if(!$config_system['inclusiveness_mail']){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('\PHPMailer\PHPMailer\PHPMailer')){
            /*фиксируем ошибку*/
            Business::fix_error('no class PHPMailer',__FILE__,__LINE__);
        }

        /*получаем настройки ппроекта*/
        $config_project = Notices::get_mission('config_project');

        /*получаем настройки коммуникации*/
        $config_communications = Notices::get_mission('config_communications');

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
            $config_project = Notices::get_mission('config_project');

            /*от кого письмо*/
            $mail->setFrom($config_project['email'], $config_project['name']);

            /*устанавливаем ссылку на коммуникацию с почтой*/
            Notices::set_mission('link_communication_with_mail',$mail);

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /*фиксируем ошибку*/
            Business::fix_error($mail->ErrorInfo,__FILE__,__LINE__);
        }

    }

    /**
     * Завершаем коммуникацию с почтой
     *
     * @return boolean
     */
    static function complete_communication_with_mail(){

        /*получаем ссылку на коммуникацию с почтой*/
        $link_communication_with_mail = Notices::get_mission('link_communication_with_mail');

        if($link_communication_with_mail == null){
            return false;
        }

        /*Обнуляем ссылку на коммуникацию с почтой*/
        Notices::delete_mission('link_communication_with_mail');

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
            $information = '['.Solutions::position_time().'] ' . $information . "\r\n";
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
    static function data_base_add_user($nickname, $password_formation, $name, $family_name, $email){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*установка*/
        $set   = [
            'nickname'    => $nickname,
            'password'    => $password_formation,
            'name'        => $name,
            'family_name' => $family_name,
            'email'       => $email
        ];

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($set as $column => $value){
                Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        try{

            $key = Data_Base::call_add_information($table, $set);

            return $key;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Добавляем запрос консоли в базу данных
     *
     * @param string $experience наработка
     * @param string $experience_goal цель
     * @param array $parameters параметры
     * @return integer|false
     */
    static function add_request_console_in_data_base($experience, $experience_goal, array $parameters){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'requests_console';

        /*установка*/
        $set   = [
            'date'        => Solutions::position_time(),
            'request'     => $experience.'/'.$experience_goal,
            'parameters'  => json_encode($parameters)
        ];

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($set as $column=>$value){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        try{

            $key = Data_Base::call_add_information($table, $set);

            return $key;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }
    }

    /*------ПОЛУЧЕНИЕ КОЛИЧЕСТВА ИНФОРМАЦИИ ИЗ БАЗЫ ДАННЫХ------*/

    /**
     * Получаем из базы данных кол-во всех пользователей
     *
     * @return integer|boolean
     */
    static function data_base_get_count_users(){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*уточнения*/
        $where = false;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        try{

            $count = Data_Base::call_count_information($table, $where);

            return $count;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }
    }

    /*------ПОЛУЧЕНИЕ ИНФОРМАЦИИ ИЗ БАЗЫ ДАННЫХ------*/

    /**
     * Получаем из базы данных всех пользователей
     *
     * @return array|boolean
     */
    static function data_base_get_users(){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*взятие*/
        $select = ['*'];

        /*условие*/
        $where = false;

        /*сортировка*/
        $sort = ['nickname' => 'ASC'];

        /*ограничение*/
        $limit = false;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($sort as $column=>$value){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        try{

            $usersData = Data_Base::call_get_information($table, $select, $where, $sort, $limit);

            return $usersData;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Получаем из базы данных id пользователя по авторизационым данным
     *
     * @param string $nickname псевдоним
     * @param string $password_formation сформированный пароль
     * @return string|boolean
     */
    static function data_base_get_user_id_by_auth_data($nickname, $password_formation){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*взятие*/
        $select = ['id'];

        /*условие*/
        $where = [
            ['nickname' => $nickname],
            'and',
            ['password' => $password_formation],
        ];

        /*сортировка*/
        $sort = false;

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($select as $column){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        try{

            $authorized_data = Data_Base::call_get_information($table, $select, $where, $sort, $limit);

            return $authorized_data ? $authorized_data['id'] : false;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Получаем из базы данных id пользователя по псевдониму
     *
     * @param string $nickname псевдоним
     * @return string|boolean
     */
    static function data_base_get_user_id_by_nickname($nickname){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*взятие*/
        $select = ['id'];

        /*условие*/
        $where = [
            ['nickname' => $nickname],
        ];

        /*сортировка*/
        $sort = false;

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($select as $column){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        /*берём данные из базы данных*/
        try{

            $authorized_data = Data_Base::call_get_information($table, $select, $where, $sort, $limit);

            return $authorized_data ? $authorized_data['id'] : false;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Получаем из базы данных информацию о пользователе по сессии
     *
     * @param integer $user_id индификационный номер пользователя
     * @param integer $session сессия пользователя
     * @return array|boolean $user_data
     */
    static function data_base_get_user_data_by_session($user_id, $session){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*взятие*/
        $select = ['*'];

        /*условие*/
        $where = [
            ['id' => $user_id],
            'and',
            ['session' => $session],
        ];

        /*сортировка*/
        $sort = false;

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        /*берём данные из базы данных*/
        try{

            $user_data = Data_Base::call_get_information($table, $select, $where, $sort, $limit);

            /*сохраняем в оперативную памятью*/
            Business::work_with_memory_data('session_'.$user_id, $user_data,false);

            return $user_data;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Получаем из базы данных id пользователя по электронному адресу
     *
     * @param string $email электронный адрес
     * @return string|boolean
     */
    static function data_base_get_user_id_by_email($email){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*взятие*/
        $select = ['id'];

        /*условие*/
        $where = [
            ['email' => $email],
        ];

        /*сортировка*/
        $sort = false;

        /*ограничение*/
        $limit = false;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        /*берём данные из базы данных*/
        try{

            $authorized_data = Data_Base::call_get_information($table, $select, $where, $sort, $limit);

            return $authorized_data ? $authorized_data['id'] : false;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Берём запрос консоли по id из базы данных
     *
     * @param integer $id идентификатор
     * @return array|false
     */
    static function get_request_console_by_id_from_data_base($id){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'requests_console';

        /*взятие*/
        $select = ['*'];

        /*условие*/
        $where = [
            ['id' => $id],
        ];

        /*сортировка*/
        $sort = false;

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        if($where){
            foreach($where as $value){
                if(is_array($value)){
                    Solutions::check_correct_taking_schema_data_base($table, key($value));
                }
            }
        }

        /*берём данные из базы данных*/
        try{

            $request_console = Data_Base::call_get_information($table, $select, $where, $sort, $limit);

            return $request_console;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }
    }

    /*------ОБНОВЛЕНИЕ ИНФОРМАЦИИ В БАЗЕ ДАННЫХ------*/

    /**
     * Обновляем в базе данных роль администрирования у пользователя
     *
     * @param integer $user_id индификационный номер пользователя
     * @param string $is_admin да-нет
     * @return boolean
     */
    static function data_base_set_user_is_admin($user_id, $is_admin){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*установка*/
        $set = [
            'is_admin' => $is_admin
        ];

        /*условие*/
        $where = [
            ['id' => $user_id],
        ];

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($set as $column=>$value){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        /*обновляем данные в базе данных*/
        try{

            $updated = Data_Base::call_update_information($table, $set, $where, $limit);

            return $updated;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }
    }

    /**
     * Обновляем в базе данных сессию у пользователя
     *
     * @param integer $user_id индификационный номер пользователя
     * @param integer $session сессия пользователя
     * @return boolean
     */
    static function data_base_upd_user_session($user_id, $session){

        /*работа с оперативной памятью*/
        Business::work_with_memory_data('session_'.$user_id, false,false,true);

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'users';

        /*установка*/
        $set = [
            'session' => $session
        ];

        /*условие*/
        $where = [
            ['id' => $user_id],
        ];

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($set as $column=>$value){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        /*обновляем данные в базе данных*/
        try{

            $updated = Data_Base::call_update_information($table, $set, $where, $limit);

            return $updated;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

    /**
     * Обновляем статус запроса консоли в базе данных
     *
     * @param integer $id идентификатор
     * @param string $status статус
     * @return boolean
     */
    static function update_status_request_console_in_data_base($id, $status){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*таблица*/
        $table = 'requests_console';

        /*установка*/
        $set = [
            'status' => $status
        ];

        /*условие*/
        $where = [
            ['id' => $id],
        ];

        /*ограничение*/
        $limit = 1;

        /*Проверяем таблицу*/
        Solutions::check_correct_taking_schema_data_base($table);

        /*Проверяем колонки*/
        foreach($set as $column=>$value){
            Solutions::check_correct_taking_schema_data_base($table, $column);
        }

        foreach($where as $value){
            if(is_array($value)){
                Solutions::check_correct_taking_schema_data_base($table, key($value));
            }
        }

        /*обновляем данные в базе данных*/
        try{

            $updated = Data_Base::call_update_information($table, $set, $where, $limit);

            return $updated;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }
    }

    /*------УДАЛЕНИЕ ИНФОРМАЦИИ ИЗ БАЗЫ ДАННЫХ------*/

    /*------СТРУКТУРА БАЗЫ ДАННЫХ------*/

    /**
     * Реконструируем базу данных
     *
     * @param string $changes изменения
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

        /*реализованная схема базы данных*/
        $realized_schema = Resources::get_information_realized_schema_data_base();

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

                            }
                        }
                    }
                    elseif($change == 'create_reference'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $reference_change){

                                /*проверяем соотвествие типов колонок*/
                                if($realized_schema[$table]['columns'][$column]['type'] != $realized_schema[$reference_change['table']]['columns'][$reference_change['column']]['type']){
                                    Business::fix_error('нет возможности создать связь у колонок '.$table.'.'.$column.' ('.$realized_schema[$table]['columns'][$column]['type'].') и '.$reference_change['table'].'.'.$reference_change['column'].' ('.$realized_schema[$reference_change['table']]['columns'][$reference_change['column']]['type'].') по причине разных типов колонок' . $instruction_when_error,__FILE__,__LINE__);
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

                        }

                    }
                    elseif($change == 'correct_comment_table'){
                        Business::fix_error('correct_comment_table не реализовано' . $instruction_when_error,__FILE__, __LINE__);
                    }
                    elseif($change == 'correct_primary_column_table'){
                        Business::fix_error('correct_primary_column_table не реализовано' . $instruction_when_error,__FILE__, __LINE__);
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

                            }
                        }
                    }
                    else{
                        Business::fix_error('no '.$change . $instruction_when_error,__FILE__, __LINE__);
                    }
                }

            }

            return true;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage() . $instruction_when_error,__FILE__,__LINE__);
        }

    }
}

?>