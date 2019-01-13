<?php

namespace Framework_life_balance\core_components;

/**
 * Суть уведомлений
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

        /* Берём настройки проекта из файла */
        $config_project = Resources::include_information_from_file(DIR_NOTICES,'Настройка проекта','php');

        if($config_project == null){
            Business::fix_error('нет файла настройки проекта',__FILE__, __LINE__);
        }

        /* Устанавливаем настройки проекта */
        Notices::set_mission('config_project',$config_project);

    }

    /*---------------------------------------------------------*/
    /*---------------------ПРЕДНАЗНАЧЕНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /* Операционная система */
    static $operating_system = null;

    /* Настройки системы */
    static $config_system = null;

    /* Настройки проекта */
    static $config_project = null;

    /* Настройки коммуникаций */
    static $config_communications = null;

    /*настройки протоколов*/
    static $config_protocols = null;

    /* Запрошенная наработка */
    static $request_experience = null;

    /* Запрошенная наработанная цель */
    static $request_experience_goal = null;

    /* Параметры запроса */
    static $parameters_request = null;

    /* Устройство пользователя */
    static $user_device = null;

    /* Удалённый адрес пользователя */
    static $user_ip = null;

    /* Индификационный номер пользователя */
    static $user_id = null;

    /* Сессия пользователя */
    static $user_session = null;

    /* Данные пользователя */
    static $user_data = null;

    /* Схема наработок */
    static $schema_experiences = null;

    /* Схема таблиц базы данных */
    static $schema_data_base = null;

    /* Схема взаимодействия с базой данных */
    static $schema_interaction_with_data_base = null;

    /* Ссылка на коммуникацию с памятью */
    static $link_communication_with_memory = null;

    /* Ссылка на коммуникацию с почтой */
    static $link_communication_with_mail = null;

    /* Вызванная наработка */
    static $call_experience = null;

    /* Вызванная наработанная цель */
    static $call_experience_goal = null;

    /* Время вызова Наработки */
    static $mark_time_call_experience= null;

    /* Результат выполнения */
    static $result_executed = null;

    /* Время выполнения */
    static $lead_time_executed = null;

    /* Номер сбоя */
    static $number_crash = null;

    /* Текст сбоя */
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

        /* Формируем ответ */
        $answer = Solutions::formation_result_executed_to_interface();

        /* Выводим ответ */
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

        /* Получаем ссылку на коммуникацию с почтой */
        $link_communication_with_mail = Notices::get_mission('link_communication_with_mail');

        /* Проверяем ссылку на коммуникацию с почтой */
        if($link_communication_with_mail == null){
            return false;
        }

        try {

            /* Получаем настройки проекта */
            $config_project = Notices::get_mission('config_project');

            /* От кого письмо */
            $link_communication_with_mail->setFrom($config_project['email'], $config_project['name']);

            /* Кому письмо */
            $link_communication_with_mail->addAddress($email);

            /* Формируем содержимое */
            $link_communication_with_mail->isHTML(true);
            $link_communication_with_mail->Subject = $title;
            $link_communication_with_mail->Body    = Solutions::formation_template($template,[
                'TITLE'        => $title,
                'TEXT'         => $text,
                'PROJECT_NAME' => $config_project['name'],
                'PROJECT_URL'  => Solutions::formation_url_project(),
            ]);
            $link_communication_with_mail->AltBody = strip_tags($text);

            /* Отправляем почту */
            $link_communication_with_mail->send();

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /* Удаляем коммуникацию с почтой */
            Notices::delete_mission('link_communication_with_mail');

            /* Фиксируем ошибку */
            Business::fix_error($e->getMessage(),__FILE__,__LINE__);
        }

    }

}