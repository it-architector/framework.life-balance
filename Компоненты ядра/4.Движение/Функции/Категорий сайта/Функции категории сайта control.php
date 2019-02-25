<?php

namespace Framework_life_balance\core_components\experiences;

use \Framework_life_balance\core_components\Representation;
use \Framework_life_balance\core_components\Orientation;
use \Framework_life_balance\core_components\Accumulation;
use \Framework_life_balance\core_components\Motion;


class Category_control
{

    static function index($parameters = [])
    {

        /*ошибки в файле лога*/
        $errors_in_file_log = Accumulation::include_information_from_file(DIR_PROTOCOLS_PROCESSES,'Ошибки в ядре','log');

        /*последняя ошибка в файле лога*/
        if($errors_in_file_log!=null){
            $last_error_in_file_log = $errors_in_file_log[(count($errors_in_file_log)-1)];
        }
        else{
            $last_error_in_file_log = false;
        }

        return [
            'last_error_in_file_log' => $last_error_in_file_log,
        ];

    }

    static function errors($parameters = [
        'delete_file_log' => null,
    ])
    {

        if(isset($parameters['delete_file_log'])){
            Accumulation::delete_file(DIR_PROTOCOLS_PROCESSES,'Ошибки в ядре','log');
        }

        /*сколько выводить ошибок на страницу*/
        $max_errors_on_page = 10;

        /*ошибки в файле лога*/
        $errors_all_in_file_log = Accumulation::include_information_from_file(DIR_PROTOCOLS_PROCESSES,'Ошибки в ядре','log');

        $errors_in_file_log = [];

        if(count($errors_all_in_file_log)>0){

            krsort($errors_all_in_file_log);

            foreach($errors_all_in_file_log as $error){
                $errors_in_file_log[] = $error;
                if(count($errors_in_file_log) == $max_errors_on_page){
                    break;
                }
            }

        }

        return [
            'errors_in_file_log' => count($errors_in_file_log)>0 ? $errors_in_file_log : null,
        ];

    }

    static function reassembly_data_base($parameters = []){

        /* Фиксируем реконструкцию базы данных */
        Motion::fix_reassembly_data_base('Запуск');

        /*получаем настройки проекта*/
        $config_project = Representation::get_mission('config_project');

        /*вызываем наработку отправления на почту*/
        Motion::call_experience('control', 'send_email', [
            'email'    => $config_project['email'],
            'title'    => 'Запущена реконструкция базы данных',
            'text'     => 'При сбое вручную запустите в консоли команду: php Ядро.php control reassembly_data_base',
            'template' => 'Норматив блоков mail'.DIRECTORY_SEPARATOR.'message',
        ]);

        /* Реализованный норматив таблиц базы данных */
        $realized_schema_data_base = Accumulation::get_information_realized_schema_data_base();

        /* Текущий норматив таблиц базы данных */
        $schema_data_base = Representation::get_mission('schema_data_base');

        /*Сопоставляем нормативы базы данных*/
        $changes = Orientation::matching_schema_data_base($realized_schema_data_base, $schema_data_base);

        $reconstruction_result = false;

        if($changes){

            /*Реконструируем базу данных*/
            $reconstruction_result = Accumulation::reconstruction_data_base($changes);

        }

        /*вызываем наработку отправления на почту*/
        Motion::call_experience('control', 'send_email', [
            'email'    => $config_project['email'],
            'title'    => 'Завершена реконструкция базы данных',
            'text'     => $reconstruction_result ? 'Изменения успешно введены.' : 'Изменений не обнаружено.',
            'template' => 'Норматив блоков mail'.DIRECTORY_SEPARATOR.'message',
        ]);

        /* Фиксируем реконструкцию базы данных */
        Motion::fix_reassembly_data_base('Завершено', true);

        return $reconstruction_result ? 'true' : 'false';

    }

    static function send_email($parameters = [
        'email'    => null,
        'title'    => null,
        'text'     => null,
        'template' => null,
    ]){

        if(isset($parameters['email']) and isset($parameters['title']) and isset($parameters['text']) and isset($parameters['template'])){

            /*создаем комуникацию с почтой*/
            Accumulation::create_communication_with_mail();

            /*отправляем письмо*/
            $sended = Representation::message_to_mail(
                $parameters['email'],
                $parameters['title'],
                $parameters['text'],
                $parameters['template']
            );
        }
        else{
            $sended = false;
        }

        return $sended ? 'true' : 'false';

    }

}
