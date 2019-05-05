<?php

namespace Framework_life_balance\core_components;


class Conditions
{

    static function initiation($parameters){

        /* Берём настройки проекта из файла */
        $config_project = Distribution::include_information_from_file([
            'Папка'          => DIR_NOTICES,
            'Название файла' => 'Настройка проекта',
            'Тип файла'      => 'php',
        ]);

        if($config_project == null){
            Motion::fix_claim([
                'Претензия'          => 'нет файла настройки проекта',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем настройки проекта */
        Conditions::set_mission([
            'Ключ'     => 'config_project',
            'Значение' => $config_project,
        ]);

    }

    static $operating_system = null;
    static $config_system = null;
    static $config_project = null;
    static $config_communications = null;
    static $config_protocols = null;
    static $request_experience = null;
    static $request_experience_goal = null;
    static $parameters_request = null;
    static $user_device = null;
    static $user_ip = null;
    static $user_id = null;
    static $user_session = null;
    static $user_data = null;
    static $schema_experiences = null;
    static $schema_data_base = null;
    static $schema_interaction_with_data_base = null;
    static $link_communication_with_memory = null;
    static $link_communication_with_mail = null;
    static $call_experience = null;
    static $call_experience_goal = null;
    static $mark_time_call_experience= null;
    static $result_executed = null;
    static $lead_time_executed = null;
    static $number_crash = null;
    static $message_crash = null;

    static function set_mission($parameters){

        $key = $parameters['Ключ'];
        $value = $parameters['Значение'];

        if(!isset(self::$$key) and self::$$key!==null){
            Motion::fix_claim([
                'Претензия'          => 'no cloud $'.$key,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        self::$$key = $value;

    }

    static function get_mission($parameters){

        $key = $parameters['Ключ'];

        if(!property_exists('\Framework_life_balance\core_components\Conditions', $key)){
            Motion::fix_claim([
                'Претензия'          => 'no cloud $'.$key,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        $value = self::$$key;

        return $value;

    }

    static function delete_mission($parameters){

        $key = $parameters['Ключ'];

        if(!property_exists('\Framework_life_balance\core_components\Conditions', $key)){
            Motion::fix_claim([
                'Претензия'          => 'no cloud $'.$key,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        self::$$key = null;

    }

    static function delete_all_missions($parameters) {

        $over_casts = get_class_vars('Framework_life_balance\core_components\Conditions');

        if(count($over_casts)>0){
            foreach($over_casts as $key=>$value){
                self::$$key = null;
            }
        }

    }

    static function result_executed_to_interface($parameters){

        /* Формируем ответ */
        $answer = Orientation::formation_result_executed_to_interface([]);

        /* Выводим ответ */
        echo $answer;

    }

    static function message_to_mail($parameters){

        $email = $parameters['Электронный адрес получателя'];
        $title = $parameters['Заголовок'];
        $text = $parameters['Текст'];
        $template = $parameters['Шаблон'];

        /* Получаем ссылку на коммуникацию с почтой */
        $link_communication_with_mail = Conditions::get_mission([
            'Ключ' => 'link_communication_with_mail',
        ]);

        /* Проверяем ссылку на коммуникацию с почтой */
        if($link_communication_with_mail == null){
            return false;
        }

        try {

            /* Получаем настройки проекта */
            $config_project = Conditions::get_mission([
                'Ключ' => 'config_project',
            ]);

            /* От кого письмо */
            $link_communication_with_mail->setFrom($config_project['email'], $config_project['name']);

            /* Кому письмо */
            $link_communication_with_mail->addAddress($email);

            /* Формируем содержимое */

            $link_communication_with_mail->isHTML(true);
            $link_communication_with_mail->Subject = $title;
            $link_communication_with_mail->Body    = Orientation::formation_template([
                'Шаблон'    => $template,
                'Параметры' => [
                    'TITLE'        => $title,
                    'TEXT'         => $text,
                    'PROJECT_NAME' => $config_project['name'],
                    'PROJECT_URL'  => Orientation::formation_url_project([]),
                ],
            ]);
            $link_communication_with_mail->AltBody = strip_tags($text);

            /* Отправляем почту */
            $link_communication_with_mail->send();

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /* Удаляем коммуникацию с почтой */
            Conditions::delete_mission([
                'Ключ' => 'link_communication_with_mail',
            ]);

            /* Фиксируем ошибку */
            Motion::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

}