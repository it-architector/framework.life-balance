<?php

namespace Framework_life_balance\core_components\experiences;

use \Framework_life_balance\core_components\Notices;
use \Framework_life_balance\core_components\Solutions;
use \Framework_life_balance\core_components\Resources;
use \Framework_life_balance\core_components\Business;

/**
 * Наработка control
 *
 * @package Framework_life_balance\core_components\experiences
 */
class Control
{
    /**
     * Главная контрольной панели
     *
     * @param array $parameters параметры
     * @return array
     */
    function index(array $parameters)
    {

        /*ошибки в файле лога*/
        $errors_in_file_log = Resources::include_information_from_file(DIR_PROTOCOLS,'Ошибки в ядре','log');

        /*последняя ошибка в файле лога*/
        if($errors_in_file_log!=null){
            $last_error_in_file_log = $errors_in_file_log[(count($errors_in_file_log)-1)];
        }
        else{
            $last_error_in_file_log = false;
        }

        return [
            'title' => 'Контрольная панель',
            'description' => '',
            'keywords' => '',
            'content' => [
                'last_error_in_file_log' => $last_error_in_file_log,
            ]
        ];

    }

    /**
     * Ошибки ядра
     *
     * @param array $parameters параметры
     * @return array
     */
    function errors(array $parameters)
    {

        if(isset($parameters['delete_file_log'])){
            Resources::delete_file(DIR_PROTOCOLS,'Ошибки в ядре','log');
        }

        /*сколько выводить ошибок на страницу*/
        $max_errors_on_page = 10;

        /*ошибки в файле лога*/
        $errors_all_in_file_log = Resources::include_information_from_file(DIR_PROTOCOLS,'Ошибки в ядре','log');

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
            'title' => 'Ошибки ядра',
            'description' => '',
            'keywords' => '',
            'content' => [
                'errors_in_file_log' => count($errors_in_file_log)>0 ? $errors_in_file_log : null,
            ]

        ];

    }

    /**
     * Пересборка таблиц и колонок в базе данных
     *
     * @param array $parameters параметры
     * @return string
     */
    function reassembly_data_base(array $parameters){

        /* Фиксируем реконструкцию базы данных */
        Business::fix_reassembly_data_base('Запуск');

        /*получаем настройки проекта*/
        $config_project = Notices::get_mission('config_project');

        /*вызываем наработку отправления на почту*/
        Business::call_experience('control', 'send_email', [
            'email'    => $config_project['email'],
            'title'    => 'Запущена реконструкция базы данных',
            'text'     => 'При сбое вручную запустите в консоли команду: php Ядро.php control reassembly_data_base',
            'template' => 'mail'.DIRECTORY_SEPARATOR.'message',
        ]);

        /*реализованная схема таблиц базы данных*/
        $realized_schema_data_base = Resources::get_information_realized_schema_data_base();

        /*текущая схема таблиц базы данных*/
        $schema_data_base = Notices::get_mission('schema_data_base');

        /*Сопоставляем Схемы базы данных*/
        $changes = Solutions::matching_schema_data_base($realized_schema_data_base, $schema_data_base);

        $reconstruction_result = false;

        if($changes){

            /*Реконструируем базу данных*/
            $reconstruction_result = Resources::reconstruction_data_base($changes);

        }

        /*вызываем наработку отправления на почту*/
        Business::call_experience('control', 'send_email', [
            'email'    => $config_project['email'],
            'title'    => 'Завершена реконструкция базы данных',
            'text'     => $reconstruction_result ? 'Изменения успешно введены.' : 'Изменений не обнаружено.',
            'template' => 'mail'.DIRECTORY_SEPARATOR.'message',
        ]);

        /* Фиксируем реконструкцию базы данных */
        Business::fix_reassembly_data_base('Завершено', true);

        return $reconstruction_result ? 'true' : 'false';

    }

    /**
     * Отправляем письмо
     *
     * @param array $parameters параметры
     * @return string
     */
    function send_email(array $parameters){

        if(isset($parameters['email']) and isset($parameters['title']) and isset($parameters['text']) and isset($parameters['template'])){

            /*создаем комуникацию с почтой*/
            Resources::create_communication_with_mail();

            /*отправляем письмо*/
            $sended = Notices::message_to_mail(
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
