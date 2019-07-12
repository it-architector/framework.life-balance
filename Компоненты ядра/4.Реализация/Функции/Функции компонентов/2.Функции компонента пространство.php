<?php

namespace Framework_life_balance\core_components;


class Space
{

    static function initiation($parameters){

        /* Берём настройки проекта из файла */
        $config_project = Distribution::include_information_from_file([
            'Папка'          => DIR_SPACE,
            'Название файла' => 'Настройка проекта',
            'Тип файла'      => 'php',
        ]);

        if($config_project == null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла настройки проекта',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем настройки проекта */
        Space::set_mission([
            'Ключ'     => 'config_project',
            'Значение' => $config_project,
        ]);

        /* Устанавливаем языковой стандарт */
        setlocale(LC_ALL, $config_project['locale']);

        /* Устанавливаем временнную зону */
        date_default_timezone_set($config_project['time_zone']);

    }

    static $operating_system = null;
    static $config_system = null;
    static $config_project = null;
    static $config_communications = null;
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
            Conditions::fix_claim([
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

        if(!property_exists('\Framework_life_balance\core_components\Space', $key)){
            Conditions::fix_claim([
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

        if(!property_exists('\Framework_life_balance\core_components\Space', $key)){
            Conditions::fix_claim([
                'Претензия'          => 'no cloud $'.$key,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        self::$$key = null;

    }

    static function delete_all_missions($parameters) {

        $over_casts = get_class_vars('Framework_life_balance\core_components\Space');

        if(count($over_casts)>0){
            foreach($over_casts as $key=>$value){
                self::$$key = null;
            }
        }

    }

}