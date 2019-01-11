<?php

namespace Framework_life_balance\core_components;

/**
 * Class Notices
 *
 * Отвечает за смысл.
 *
 * Особенности:
 * - предназначение
 * - отношения
 *
 * @package Framework_life_balance\core_components
 */
class Notices implements Structure_Notices
{

    /**
     * Определяем вывод информации
     *
     * @return null
     */
    static function initiation(){

        /*берём настройки проекта из файла*/
        $config_project = Resources::include_information_from_file(DIR_NOTICES,'настройка_проекта','php');

        if($config_project == null){
            Business::fix_error('нет файла настройки проекта',__FILE__, __LINE__);
        }

        /*устанавливаем настройки проекта*/
        Notices::set_mission('config_project',$config_project);

    }

    /*---------------------------------------------------------*/
    /*---------------------ПРЕДНАЗНАЧЕНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /*операционная система*/
    static $operating_system = null;

    /*настройки системы*/
    static $config_system = null;

    /*настройки проекта*/
    static $config_project = null;

    /*настройки коммуникаций*/
    static $config_communications = null;

    /*настройки протоколов*/
    static $config_protocols = null;

    /*запрошенная наработка*/
    static $request_experience = null;

    /*запрошенная наработанная цель*/
    static $request_experience_goal = null;

    /*параметры запроса*/
    static $parameters_request = null;

    /*Устройство пользователя*/
    static $user_device = null;

    /*удалённый адрес пользователя*/
    static $user_ip = null;

    /*индификационный номер пользователя*/
    static $user_id = null;

    /*сессия пользователя*/
    static $user_session = null;

    /*данные пользователя*/
    static $user_data = null;

    /*схема наработок*/
    static $schema_experiences = null;

    /*схема базы данных*/
    static $schema_data_base = null;

    /*ссылка на коммуникацию с памятью*/
    static $link_communication_with_memory = null;

    /*ссылка на коммуникацию с почтой*/
    static $link_communication_with_mail = null;

    /*вызванная наработка*/
    static $call_experience = null;

    /*вызванная наработанная цель*/
    static $call_experience_goal = null;

    /*время вызова наработки*/
    static $mark_time_call_experience= null;

    /*результат выполнения*/
    static $result_executed = null;

    /*время выполнения*/
    static $lead_time_executed = null;

    /*номер сбоя*/
    static $number_crash = null;

    /*текст сбоя*/
    static $message_crash = null;

    /**
     * Устанавливаем предназначение
     *
     * @param string $key ключ
     * @param string $value значение
     */
    static function set_mission($key,$value){

        if(!isset(self::$$key) and self::$$key!==null){
            Business::fix_error('no cloud $'.$key);
        }

        self::$$key = $value;

    }

    /**
     * Получаем предназначение
     *
     * @param string $key ключ
     * @return string|array|null $value значение
     */
    static function get_mission($key){

        if(!property_exists('\Framework_life_balance\core_components\Notices', $key)){
            Business::fix_error('no cloud $'.$key);
        }

        $value = self::$$key;

        return $value;

    }

    /**
     * Удаляем предназначение
     *
     * @param string $key ключ
     */
    static function delete_mission($key){

        if(!property_exists('\Framework_life_balance\core_components\Notices', $key)){
            Business::fix_error('no cloud $'.$key);
        }

        self::$$key = null;

    }

    /**
     * Удаляем все предназначения
     *
     * @return null
     */
    static function delete_all_missions() {

        $over_casts = get_class_vars('Framework_life_balance\core_components\Notices');

        if(count($over_casts)>0){
            foreach($over_casts as $key=>$value){
                self::$$key = null;
            }
        }

    }

    /*---------------------------------------------------------*/
    /*----------------------ОТНОШЕНИЯ--------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Результат выполнения в интерфейс
     *
     * @return string null
     */
    static function result_executed_to_interface(){

        /*Формируем ответ*/
        $answer = Solutions::formation_result_executed_to_interface();

        /*выводим ответ*/
        echo $answer;

    }

    /**
     * Сообщение на почту
     *
     * @param string $email электронный адрес получателя
     * @param string $title заголовок
     * @param string $text текст
     * @param string $template шаблон
     * @return boolean
     */
    static function message_to_mail($email, $title, $text, $template){

        /*получаем ссылку на коммуникацию с почтой*/
        $link_communication_with_mail = Notices::get_mission('link_communication_with_mail');

        /*проверяем ссылку на коммуникацию с почтой*/
        if($link_communication_with_mail == null){
            return false;
        }

        try {

            /*получаем настройки проекта*/
            $config_project = Notices::get_mission('config_project');

            /*от кого письмо*/
            $link_communication_with_mail->setFrom($config_project['email'], $config_project['name']);

            /*кому письмо*/
            $link_communication_with_mail->addAddress($email);

            /*формируем содержимое*/
            $link_communication_with_mail->isHTML(true);
            $link_communication_with_mail->Subject = $title;
            $link_communication_with_mail->Body    = Solutions::formation_template($template,[
                'TITLE'        => $title,
                'TEXT'         => $text,
                'PROJECT_NAME' => $config_project['name'],
                'PROJECT_URL'  => Solutions::formation_url_project(),
            ]);
            $link_communication_with_mail->AltBody = strip_tags($text);

            /*отправляем почту*/
            $link_communication_with_mail->send();

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /*удаляем коммуникацию с почтой*/
            Notices::delete_mission('link_communication_with_mail');

            /*фиксируем ошибку*/
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

}