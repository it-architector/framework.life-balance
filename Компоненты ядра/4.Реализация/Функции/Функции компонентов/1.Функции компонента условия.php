<?php

namespace Framework_life_balance\core_components;

class Conditions
{

    static function initiation($parameters){

        /* Берём настройки системы из файла */
        $config_system = Distribution::include_information_from_file([
            'Папка'          => DIR_CONDITIONS,
            'Название файла' => 'Настройка системы',
            'Тип файла'      => 'php',
        ]);

        if($config_system === null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла настройки системы',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем настройки системы */
        Space::set_mission([
            'Ключ'     => 'config_system',
            'Значение' => $config_system,
        ]);

        /* Определяем операционную систему */
        self::detect_operating_system([]);

        /* Отключаем вывод ошибок в интерфейс */
        error_reporting(E_ALL);

        /* Включаем выявление ошибки */
        register_shutdown_function(function(){
            self::detect_error([]);
        });

    }

    static function fix_claim($parameters){

        $error_message = $parameters['Претензия'];
        $file_name = $parameters['Файл'];
        $num_line_on_file_error = $parameters['Номер строчки в файле'];
        $stub = $parameters['Заглушка страницы'];

        /*запоминаем при error*/
        if($stub == 'error'){

            /*номер ошибки*/
            $number_crash = Space::get_mission([
                    'Ключ' => 'number_crash',
                ]) + 1;

            /*устанавливаем номер ошибки*/
            Space::set_mission([
                'Ключ'     => 'number_crash',
                'Значение' => $number_crash,
            ]);

            /*устанавливаем ошибку сбоя*/
            Space::set_mission([
                'Ключ'     => 'message_crash',
                'Значение' => $error_message,
            ]);

            /*исключаем зацикленность самовызова*/
            if($number_crash==2){

                echo 'Критическая ошибка. Смотрите протокол /Компоненты ядра/1.Условия/2.Сведения/Сведения о процессах/Претензии в ядре.log';

                /*прекращаем работу ядра*/
                Conditions::stop_core([]);

            }

        }

        /*формируем сообщение об ошибке в одну строку*/
        $error_message = trim(str_replace(["\r\n","\n","\r"], ' ', $error_message));

        /*получаем настройки протоколов*/
        $config_system = Space::get_mission([
            'Ключ' => 'config_system',
        ]);

        /*на случай сбоя инициации*/
        if($config_system === null){
            $config_system['Претензии в ядре'] = true;
        }

        /*запись в протокол нужна*/
        if($config_system['Претензии в ядре'] == true){

            $request_experience = Space::get_mission([
                'Ключ' => 'request_experience',
            ]);
            $request_experience_goal = Space::get_mission([
                'Ключ' => 'request_experience_goal',
            ]);

            $user_ip = Space::get_mission([
                'Ключ' => 'user_ip',
            ]);

            $position_time = Conditions::position_time([
                'Формат'  => 'Y-m-d H:i:s',
            ]);

            $error_json = json_encode([
                'date' => $position_time,
                'request_experience' => $request_experience,
                'request_experience_goal' => $request_experience_goal,
                'user_ip' => $user_ip,
                'error_message' => $error_message,
                'file_name' => $file_name,
                'num_line_on_file_error' => $num_line_on_file_error,
            ]);

            /*записываем ошибку в файл*/
            Distribution::write_information_in_file([
                'Папка'          => DIR_PROTOCOLS_PROCESSES,
                'Название файла' => 'Претензии в ядре',
                'Тип файла'      => 'log',
                'Текст'          => $error_json,
            ]);

        }

        $user_device = Space::get_mission([
            'Ключ' => 'user_device',
        ]);

        /* Исключаем зацикленность вызова из консоли*/
        if($user_device == 'console'){

            /*прекращаем работу ядра*/
            Conditions::stop_core([]);

        }

        /*получаем настройки проекта*/
        $config_project = Space::get_mission([
            'Ключ' => 'config_project',
        ]);

        /*если нет сбоя инициации*/
        if($config_project != null){

            $request_experience = Space::get_mission([
                'Ключ' => 'request_experience',
            ]);
            $request_experience_goal = Space::get_mission([
                'Ключ' => 'request_experience_goal',
            ]);

            /*вызываем консоль наработку отправления на почту*/
            Realization::call_console_experience([
                'Наработка'         => 'control',
                'Наработанная цель' => 'send_email',
                'Параметры'         => [
                    'email'    => $config_project['email'],
                    'title'    => 'Ошибка ядра',
                    'text'     => 'По запросу /'.$request_experience.'/'.$request_experience_goal.':<br><b>'.$error_message.'</b>',
                    'template' => 'Элементы тэгов mail'.DIRECTORY_SEPARATOR.'message',
                ],
            ]);

        }

        /*выводим заглушку*/
        if($stub){

            /*Вызываем выполнение информирования ошибки или остановки*/
            $result_executed = Realization::call_experience([
                'Наработка'         => 'index',
                'Наработанная цель' => $stub,
                'Параметры'         => [
                    'code'=>$error_message
                ],
            ]);

            /*устанавливаем результат выполнения*/
            Space::set_mission([
                'Ключ'     => 'result_executed',
                'Значение' => $result_executed,
            ]);

            /*результат выполнения в интерфейс*/
            Realization::result_executed_to_interface([]);

            /*Прекращаем работу ядра*/
            Conditions::stop_core([]);

        }

    }

    static function check_request_legality($parameters){

        /*запрошенная наработка*/
        $request_experience = Space::get_mission([
            'Ключ' => 'request_experience',
        ]);

        /*запрошенная наработанная цель*/
        $request_experience_goal = Space::get_mission([
            'Ключ' => 'request_experience_goal',
        ]);

        /*Проверяем правильное взятие норматива наработок*/
        self::check_correct_taking_schema_experience([
            'Наработка' => $request_experience,
            'Цель'      => $request_experience_goal,
            'Деталь'    => null,
            'Заглушка'  => 'stop',
        ]);

    }

    static function check_request_destructive($parameters){

        /*получаем параметры запроса*/
        $parameters_request = Space::get_mission([
            'Ключ' => 'parameters_request',
        ]);

        if(count($parameters_request)==0){
            return;
        }

        /*губительные данные*/
        $destructive_data =[
            '<script',
            '<frame',
        ];

        foreach($parameters_request as $key=>$value){
            foreach($destructive_data as $string){
                if(substr_count(mb_strtolower($value),mb_strtolower($string))){
                    Conditions::fix_claim([
                        'Претензия'          => 'обнаружены губительные данные ('.htmlspecialchars($string).') в '.htmlspecialchars($key).': '.htmlspecialchars($value),
                        'Файл'                  => __FILE__,
                        'Номер строчки в файле' => __LINE__,
                        'Заглушка страницы'     => 'stop',
                    ]);
                }
            }
        }

    }

    static function check_changes_schema_data_base($parameters){

        /*запрошенная наработка*/
        $request_experience = Space::get_mission([
            'Ключ' => 'request_experience',
        ]);

        /*запрошенная наработанная цель*/
        $request_experience_goal = Space::get_mission([
            'Ключ' => 'request_experience_goal',
        ]);

        /*для такой Цели делать проверку нет надобности*/
        if(($request_experience.'/'.$request_experience_goal) == 'control/reassembly_data_base'){
            return;
        }

        /* Реализованный норматив таблиц базы данных */
        $realized_schema_data_base = Distribution::get_information_realized_schema_data_base([]);

        /* Текущий норматив таблиц базы данных */
        $schema_data_base = Space::get_mission([
            'Ключ' => 'schema_data_base',
        ]);

        /*Сопоставляем норматива базы данных*/
        $changes = self::matching_schema_data_base([
            'Реализованная схема' => $realized_schema_data_base,
            'Текущая схема'       => $schema_data_base,
        ]);

        /*есть изменения*/
        if($changes){

            /* Проверяем запущен ли процес реструктуризации */
            if(Distribution::include_information_from_file([
                'Папка'          => DIR_PROTOCOLS_PROCESSES,
                'Название файла' => 'Текущая реконструкция базы данных',
                'Тип файла'      => 'log',
            ]) === null){

                /* Фиксируем реконструкцию базы данных */
                Realization::fix_reassembly_data_base([
                    'Информация' => 'Вызов',
                    'Завершение' => false,
                ]);

                /*вызываем консоль наработку реструктуризации базы данных*/
                Realization::call_console_experience([
                    'Наработка'         => 'control',
                    'Наработанная цель' => 'reassembly_data_base',
                    'Параметры'         => [],
                ]);

            }

            $user_device = Space::get_mission([
                'Ключ' => 'user_device',
            ]);

            if($user_device != 'console'){

                /*Ставим заглушку сообщающую о технических работах*/
                Conditions::fix_claim([
                    'Претензия'          => 'технические работы с базой данных',
                    'Файл'                  => __FILE__,
                    'Номер строчки в файле' => __LINE__,
                    'Заглушка страницы'     => 'engineering_works',
                ]);

            }
        }

    }

    static function check_request_access($parameters)
    {

        /* Запрощенная наработка */
        $request_experience = Space::get_mission([
            'Ключ' => 'request_experience',
        ]);

        /* Запрощенная наработанная цель */
        $request_experience_goal = Space::get_mission([
            'Ключ' => 'request_experience_goal',
        ]);

        /* Кому предназначена наработанная цель */
        $experience_goal_intended = Distribution::schema_experience([
            'Наработка' => $request_experience,
            'Цель'      => $request_experience_goal,
            'Деталь'    => 'intended',
        ]);

        switch ($experience_goal_intended) {
            /*всем*/
            case 'any':
                return true;
                break;
            /*только для не авторизованных*/
            case 'unauthorized':
                if (!Realization::data_authorized_user([
                    'Показать определенную часть данных' => null,
                ])){
                    return true;
                }
                else{
                    Conditions::fix_claim([
                        'Претензия'          => 'only_unauthorized',
                        'Файл'                  => __FILE__,
                        'Номер строчки в файле' => __LINE__,
                        'Заглушка страницы'     => 'stop',
                    ]);
                }
                break;
            /*только для авторизованных*/
            case 'authorized':
                if (Realization::data_authorized_user([
                    'Показать определенную часть данных' => null,
                ])){
                    return true;
                }
                else{
                    Conditions::fix_claim([
                        'Претензия'          => 'only_authorized',
                        'Файл'                  => __FILE__,
                        'Номер строчки в файле' => __LINE__,
                        'Заглушка страницы'     => 'stop',
                    ]);
                }
                break;
            /*только для администраторов*/
            case 'authorized_by_administrator':
                if (Realization::data_authorized_user([
                        'Показать определенную часть данных' => null,
                    ]) and Realization::data_authorized_user([
                        'Показать определенную часть данных' => 'is_admin',
                    ]) == 'true'){
                    return true;
                }
                else{
                    Conditions::fix_claim([
                        'Претензия'          => 'only_authorized_by_admin',
                        'Файл'                  => __FILE__,
                        'Номер строчки в файле' => __LINE__,
                        'Заглушка страницы'     => 'stop',
                    ]);
                }
                break;
            /*только для запуска из под консоли*/
            case 'console':
                $user_device = Space::get_mission([
                    'Ключ' => 'user_device',
                ]);
                if($user_device == 'console'){
                    return true;
                }
                else{
                    Conditions::fix_claim([
                        'Претензия'          => 'only_console',
                        'Файл'                  => __FILE__,
                        'Номер строчки в файле' => __LINE__,
                        'Заглушка страницы'     => 'stop',
                    ]);
                }
                break;
        }

    }

    static function check_correct_taking_schema_experience($parameters){

        $experience = $parameters['Наработка'];
        $goal = $parameters['Цель'];
        $detail = $parameters['Деталь'];
        $call_index_goal_on_error = $parameters['Заглушка'];

        /*получаем схему наработок*/
        $schema_experiences = Space::get_mission([
            'Ключ' => 'schema_experiences',
        ]);

        if($schema_experiences == null){
            Conditions::fix_claim([
                'Претензия'          => 'нет номратива наработок',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }

        /*проверка*/
        if($experience!=null and !isset($schema_experiences[$experience])){
            Conditions::fix_claim([
                'Претензия'          => 'нет функции сайта '.$experience,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }
        elseif($goal!=null and !isset($schema_experiences[$experience]['goals'][$goal])){
            Conditions::fix_claim([
                'Претензия'          => 'Цели '.$goal.' нет в функции сайта '.$experience,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }
        elseif($experience!=null and $goal==null and $detail!=null and !isset($schema_experiences[$experience][$detail])){
            Conditions::fix_claim([
                'Претензия'          => 'нет детали '.$detail.' у функций сайта '.$experience,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }
        elseif($goal!=null and $detail!=null and !isset($schema_experiences[$experience]['goals'][$goal][$detail])){
            Conditions::fix_claim([
                'Претензия'          => 'нет детали '.$detail.' у Цели '.$goal.' в наработке '.$experience,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }

    }

    static function check_correct_taking_schema_data_base($parameters){

        $table = $parameters['Таблица'];
        $column = $parameters['Колонка'];
        $detail = $parameters['Деталь'];
        $call_index_goal_on_error = $parameters['Заглушка'];

        /*получаем схему базы данных*/
        $schema_data_base = Space::get_mission([
            'Ключ' => 'schema_data_base',
        ]);

        if($schema_data_base == null){
            Conditions::fix_claim([
                'Претензия'          => 'нет Элементыа базы данных',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }

        /*проверка*/
        if($table!=null and !isset($schema_data_base[$table])){
            Conditions::fix_claim([
                'Претензия'          => 'нет таблицы '.$table,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }
        elseif($column!=null and !isset($schema_data_base[$table]['columns'][$column])){
            Conditions::fix_claim([
                'Претензия'          => 'колонки '.$column.' нет в таблице '.$table,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }
        elseif($table!=null and $column==null and $detail!=null and !isset($schema_data_base[$table][$detail])){
            Conditions::fix_claim([
                'Претензия'          => 'нет детали '.$detail.' у таблицы '.$table,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }
        elseif($column!=null and $detail!=null and !isset($schema_data_base[$table]['columns'][$column][$detail])){
            Conditions::fix_claim([
                'Претензия'          => 'нет детали '.$detail.' у колонки '.$column.' в таблице '.$table,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => $call_index_goal_on_error,
            ]);
        }

    }

    static function position_time($parameters)
    {

        $format = $parameters['Формат'];

        try{
            $date_class = new \DateTime();
            $date = $date_class->format($format);

            return $date;
        }
        catch (\Exception $e){
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }
    }

    static function mark_start_execution_experience($parameters){

        /*устанавливаем время вызова функци сайта*/
        Space::set_mission([
            'Ключ'     => 'mark_time_call_experience',
            'Значение' => time(),
        ]);

        /*вызванная наработка*/
        $call_experience = Space::get_mission([
            'Ключ' => 'call_experience',
        ]);

        /*вызванная наработанная цель*/
        $call_experience_goal = Space::get_mission([
            'Ключ' => 'call_experience_goal',
        ]);

        /*выделенное время на выполнение наработанной Цели*/
        $lead_time_seconds = Distribution::schema_experience([
            'Наработка' => $call_experience,
            'Цель'      => $call_experience_goal,
            'Деталь'    => 'lead_time',
        ]);

        if(!$lead_time_seconds){
            $lead_time_seconds = 1;
        }

            set_time_limit(($lead_time_seconds + 5));

    }

    static function mark_stop_execution_experience($parameters){

        /*вычисляем время выполнения*/
        $lead_time_executed = time() - Space::get_mission([
                'Ключ' => 'mark_time_call_experience',
            ]);

        /*время выполнения*/
        Space::set_mission([
            'Ключ'     => 'lead_time_executed',
            'Значение' => $lead_time_executed,
        ]);

        /*вызванная наработка*/
        $call_experience = Space::get_mission([
            'Ключ' => 'call_experience',
        ]);

        /*вызванная наработанная цель*/
        $call_experience_goal = Space::get_mission([
            'Ключ' => 'call_experience_goal',
        ]);

        /*выделенное время на выполнение наработанной Цели*/
        $lead_time_seconds = Distribution::schema_experience([
            'Наработка' => $call_experience,
            'Цель'      => $call_experience_goal,
            'Деталь'    => 'lead_time',
        ]);

        /*обнаружено превышение времени выполнения*/
        if($lead_time_executed>$lead_time_seconds){
            Conditions::fix_claim([
                'Претензия'          => 'Превышения выполнения цели '.$call_experience_goal.' функции сайта '.$call_experience.' на ' . ($lead_time_executed-$lead_time_seconds) . ' сек.',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => false,
            ]);
        }

    }

    static function detect_error($parameters)
    {

        if (Space::get_mission([
            'Ключ' => 'message_crash',
        ])==null and @is_array($e = @error_get_last())) {

            /*данные на ошибку*/
            $error_no = isset($e['type']) ? $e['type'] : 0;
            $error_message = isset($e['message']) ? $e['message'] : '';
            $file_name = isset($e['file']) ? $e['file'] : '';
            $file_line = isset($e['line']) ? $e['line'] : '';

            if ($error_no > 0) {
                Conditions::fix_claim([
                    'Претензия'          => $error_message,
                    'Файл'                  => __FILE__,
                    'Номер строчки в файле' => __LINE__,
                    'Заглушка страницы'     => 'error',
                ]);
            }

        }

    }

    static function detect_operating_system($parameters){
        /*windows*/
        if (substr(php_uname(), 0, 7) == "Windows"){
            Space::set_mission([
                'Ключ'     => 'operating_system',
                'Значение' => 'windows',
            ]);
        }
        /*unix*/
        else{
            Space::set_mission([
                'Ключ'     => 'operating_system',
                'Значение' => 'unix',
            ]);
        }
    }

    static function detect_path_executable_php($parameters){

        $path_executable_php = false;

        $paths = explode(PATH_SEPARATOR, getenv('PATH'));

        foreach ($paths as $path){

            /*для windows xampp*/
            if(Space::get_mission([
                'Ключ' => 'operating_system',
            ]) == "windows" and strstr($path, 'php.exe') and file_exists($path) and is_file($path)){
                $path_executable_php = $path;
                break;
            }
            else{

                /*предполагаем*/
                $path_executable_php = $path . DIRECTORY_SEPARATOR . "php" . (Space::get_mission([
                        'Ключ' => 'operating_system',
                    ]) == "windows" ? ".exe" : "");

                if (file_exists($path_executable_php) && is_file($path_executable_php)) {
                    break;
                }
                else{
                    $path_executable_php = false;
                }

            }

        }

        if(!$path_executable_php){
            Conditions::fix_claim([
                'Претензия'          => 'no path_executable_php',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        return $path_executable_php;
    }

    static function check_answer_correct($parameters){

        /*Выявляем ошибку*/
        Conditions::detect_error([]);

        /*вызванная наработка*/
        $call_experience = Space::get_mission([
            'Ключ' => 'call_experience',
        ]);

        /*вызванная наработанная цель*/
        $call_experience_goal = Space::get_mission([
            'Ключ' => 'call_experience_goal',
        ]);

        /*формат результата наработанной Цели*/
        $format_result = Distribution::schema_experience([
            'Наработка' => $call_experience,
            'Цель'      => $call_experience_goal,
            'Деталь'    => 'format_result',
        ]);

        /*результат выполнения наработанной Цели*/
        $result_executed = Space::get_mission([
            'Ключ' => 'result_executed',
        ]);

        if($format_result == 'array' and !is_array($result_executed)){
            Conditions::fix_claim([
                'Претензия'          => 'no_array_in_result_executed',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }
        elseif($format_result == 'text' and is_array($result_executed)){
            Conditions::fix_claim([
                'Претензия'          => 'no_content_in_result_executed',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

    static function stop_core($parameters){

        /*Завершаем коммуникацию с базой данных*/
        Distribution::complete_communication_with_data_base([]);

        /*Завершаем коммуникацию с памятью*/
        Distribution::complete_communication_with_memory([]);

        /*Завершаем коммуникацию с почтой*/
        Distribution::complete_communication_with_mail([]);

        /*Удаляем все предназначения*/
        Space::delete_all_missions([]);

        exit;
    }

    static function parse_request($parameters){

        if(isset($_SERVER['argv'][0])){

            /*устройство пользователя*/
            $user_device = 'console';

            /*наработка*/
            $request_experience  = (isset($_SERVER['argv'][1]) and $_SERVER['argv'][1]!='') ? $_SERVER['argv'][1] : 'index';

            /*цель Наработки*/
            $request_experience_goal = (isset($_SERVER['argv'][2]) and $_SERVER['argv'][2]!='') ? $_SERVER['argv'][2] : 'index';

        }
        else{

            /*устройство пользователя*/
            $user_device = 'browser';

            /*разбираем запрос Наработки*/
            $request_experience_explode = !empty($_GET['request']) ? explode('/', $_GET['request']) : [];

            /*наработка*/
            $request_experience  = (isset($request_experience_explode[1]) and $request_experience_explode[1]!='') ? $request_experience_explode[1] : 'index';

            /*цель Наработки*/
            $request_experience_goal = (isset($request_experience_explode[2]) and $request_experience_explode[2]!='') ? $request_experience_explode[2] : 'index';

        }

        /*формируем наработку*/
        $request_experience = htmlspecialchars(mb_strtolower($request_experience));

        /*формируем цель Наработки*/
        $request_experience_goal = htmlspecialchars(mb_strtolower($request_experience_goal));

        /*устанавливаем откуда запрос*/
        Space::set_mission([
            'Ключ'     => 'user_device',
            'Значение' => $user_device,
        ]);

        /*устанавливаем запрошенные Наработки*/
        Space::set_mission([
            'Ключ'     => 'request_experience',
            'Значение' => $request_experience,
        ]);

        /*устанавливаем запрошенную наработанную цель*/
        Space::set_mission([
            'Ключ'     => 'request_experience_goal',
            'Значение' => $request_experience_goal,
        ]);

    }

    static function parse_parameters_request($parameters){

        /*параметры запроса*/
        $parameters_request = [];

        /*получаем откуда запрос*/
        $user_device = Space::get_mission([
            'Ключ' => 'user_device',
        ]);

        if($user_device == 'console'){

            /*паметры запроса*/
            if(isset($_SERVER['argv'][3]) and $_SERVER['argv'][3]>0){

                /* Получаем параметры из базы данных */
                $request_console = Distribution::interchange_information_with_data_base([
                    'Направление' => 'Получение',
                    'Чего'        => 'Информации о запуске из консоли по id',
                    'Значение'    => [
                        ':id' => $_SERVER['argv'][3]
                    ],
                ]);

                if($request_console and isset($request_console['parameters'])){

                    /* Обновляем статус запроса консоли в базе данных */
                    Distribution::interchange_information_with_data_base([
                        'Направление' => 'Изменение',
                        'Чего'        => 'Статуса запуска консоли',
                        'Значение'    => [
                            ':id'     => $_SERVER['argv'][3],
                            ':status' => 'do',
                        ],
                    ]);

                    /*параметры запроса*/
                    $parameters_request = json_decode($request_console['parameters'],1);

                }
                else{
                    $parameters_request = [];
                }

            }
            else{
                $parameters_request = [];
            }

        }
        elseif($user_device == 'browser'){
            /*параметры запроса*/
            $parameters_request = (array)@$_GET + (array)@$_POST;
        }
        else{
            Conditions::fix_claim([
                'Претензия'          => 'unknown user_device: ' . $user_device,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /*устанавливаем параметры запроса*/
        Space::set_mission([
            'Ключ'     => 'parameters_request',
            'Значение' => $parameters_request,
        ]);

    }

    static function parse_authorized($parameters){

        if(isset($_COOKIE["user_id"]) and $_COOKIE["user_id"]!=false and isset($_COOKIE["user_session"])){

            $formation_user_session = Conditions::formation_user_session([
                'Идентификатор пользователя' => $_COOKIE["user_id"],
            ]);

            if($_COOKIE["user_session"] == $formation_user_session){

                /*индификационный номер пользователя*/
                $user_id = $_COOKIE["user_id"];

                /*сессия пользователя*/
                $user_session = $_COOKIE["user_session"];

                /*устанавливаем индификационный номер пользователя*/
                Space::set_mission([
                    'Ключ'     => 'user_id',
                    'Значение' => $user_id,
                ]);

                /*устанавливаем сессию пользователя*/
                Space::set_mission([
                    'Ключ'     => 'user_session',
                    'Значение' => $user_session,
                ]);

            }


        }

        /*устанавливаем удалённый адрес пользователя*/
        Space::set_mission([
            'Ключ'     => 'user_ip',
            'Значение' => Conditions::definition_user_ip([]),
        ]);

    }

    static function formation_user_session($parameters){

        $user_id = $parameters['Идентификатор пользователя'];

        $session = md5('formation-'.$user_id.'-'.$_SERVER['SERVER_ADDR']);

        return $session;
    }

    static function formation_user_password($parameters){

        $password = $parameters['Пароль пользователя'];

        $password_formation = md5('formation-'.$password);

        return $password_formation;
    }

    static function formation_result_executed_to_interface($parameters){

        /*текст ответа*/
        $answer ='';

        /*вызванная наработка*/
        $call_experience = Space::get_mission([
            'Ключ' => 'call_experience',
        ]);

        /*вызванная наработанная цель*/
        $call_experience_goal = Space::get_mission([
            'Ключ' => 'call_experience_goal',
        ]);

        /* Схема вызванной наработанной цели */
        $schema_call_experience_goal = Distribution::schema_experience([
            'Наработка' => $call_experience,
            'Цель'      => $call_experience_goal,
            'Деталь'    => null,
        ]);

        /*результат выполнения наработанной Цели*/
        $content = Space::get_mission([
            'Ключ' => 'result_executed',
        ]);

        /* Формируем содержимое ответа */
        switch ($schema_call_experience_goal['format_result']){
            case 'text':
                $answer = $content;
                break;
            case 'array':

                /* Категория */
                $result_executed['category'] = Space::get_mission([
                    'Ключ' => 'call_experience',
                ]);

                /* Цель */
                $result_executed['goal'] = Space::get_mission([
                    'Ключ' => 'call_experience_goal',
                ]);

                /*заголовок*/
                $result_executed['title'] = htmlspecialchars($schema_call_experience_goal['Заголовок страницы']);

                /*короткое описание*/
                $result_executed['description'] = htmlspecialchars($schema_call_experience_goal['Описание страницы']);

                /*ключевое описание*/
                $result_executed['keywords'] = htmlspecialchars($schema_call_experience_goal['Ключевики страницы']);

                /* Содержание */
                $result_executed['content'] = $content;

                /*кодируем ответ по json*/
                $answer = json_encode($result_executed);

                break;
        }

        /* Ответ в браузер */
        if(Space::get_mission([
            'Ключ' => 'user_device',
        ])=='browser'){

            /*всегда 200 код ответа*/
            http_response_code(200);

            $expires = Conditions::position_time([
                'Формат'  => 'r',
            ]);

            /*объявляем запрет на кэширование*/
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Expires: " . $expires);

            if($schema_call_experience_goal['format_result'] == 'array'){

                header('Content-Type: application/json');

            }

        }
        /* Ответ в консоль */
        elseif(Space::get_mission([
            'Ключ' => 'user_device',
        ])=='console'){

        }

        return $answer;

    }

    static function definition_user_ip($parameters){

        if(isset($_SERVER['REMOTE_ADDR'])){
            $user_ip = $_SERVER['REMOTE_ADDR'];
        }
        else{
            $user_ip = '127.0.0.1';
        }

        return $user_ip;

    }

    static function formation_template($parameters){

        $template = $parameters['Шаблон'];
        $template_parameters = $parameters['Параметры'];

        /*получаем шаблон*/
        $body = Distribution::include_information_from_file([
            'Папка'          => DIR_HTML,
            'Название файла' => $template,
            'Тип файла'      => 'html',
        ]);

        if($body === null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла html шаблона: '.$template,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        foreach($template_parameters as $key=>$value){
            $body = str_replace('{'.$key.'}',$value,$body);
        }

        return $body;

    }

    static function formation_url_project($parameters){

        /*получаем настройки системы*/
        $config_system = Space::get_mission([
            'Ключ' => 'config_system',
        ]);

        /*получаем настройки проекта*/
        $config_project = Space::get_mission([
            'Ключ' => 'config_project',
        ]);

        /*ссылка проекта*/
        $url_project = (($config_system['inclusiveness_ssl'])?'https':'http').'://'.$config_project['url'];

        return $url_project;

    }

    static function formation_console_command_call_experience($parameters){

        $experience = $parameters['Наработка'];
        $experience_goal = $parameters['Цель'];
        $id_save_parameters = $parameters['Идентификатор сохранённых параметров'];

        $command = self::detect_path_executable_php([]) . ' ' . DIR_ROOT . 'Ядро.php' . ' ' . $experience . ' ' . $experience_goal . ' ' . $id_save_parameters;

        /*команда для windows*/
        if(Space::get_mission([
            'Ключ' => 'operating_system',
        ]) == "windows"){
            $command = "start /B " . $command;
        }
        /*команда для unix*/
        elseif(Space::get_mission([
            'Ключ' => 'operating_system',
        ]) == "unix"){
            $command = $command . " > /dev/null &";
        }
        else{
            Conditions::fix_claim([
                'Претензия'          => 'no operating_system',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        return $command;

    }

    static function matching_schema_data_base($parameters){

        $realized_schema = $parameters['Реализованная схема'];
        $current_schema = $parameters['Текущая схема'];

        if(json_encode($realized_schema) == json_encode($current_schema)){
            return false;
        }

        $matching = [];

        foreach(['delete','create'] as $do){

            $schema_1 = [];
            $schema_2 = [];

            switch($do){
                case 'delete':
                    $schema_1 = $realized_schema;
                    $schema_2 = $current_schema;
                    break;
                case 'create':
                    $schema_1 = $current_schema;
                    $schema_2 = $realized_schema;
                    break;
            }

            /*проверяем*/
            foreach($schema_1 as $table=>$table_data){

                /*проявляем таблицу*/
                if(!isset($schema_2[$table])){
                    $matching[$do.'_table'][$table] = [
                        'description'             => $table_data['description'],
                        'primary_column'      => $table_data['primary_column'],
                        'primary_column_data' => $table_data['columns'][$table_data['primary_column']],
                    ];
                }
                elseif($do=='create' and $table_data['description']!=$schema_2[$table]['description']){

                    $matching['correct_comment_table'][$table] = [
                        'description' => $table_data['description']
                    ];

                }
                elseif($do=='create' and $table_data['primary_column']!=$schema_2[$table]['primary_column']){

                    $matching['correct_primary_column_table'][$table] = [
                        'primary_column'      => $table_data['primary_column'],
                        'primary_column_data' => $table_data['columns'][$table_data['primary_column']],
                    ];
                }

                /*проявляем колонки*/
                foreach($table_data['columns'] as $column=>$column_data){

                    if(!isset($schema_2[$table]['columns'][$column])){
                        if($table_data['primary_column']==$column){
                            continue;
                        }
                        $matching[$do.'_column'][$table][$column] = $column_data;
                    }
                    elseif($do=='create' and (
                        $schema_2[$table]['columns'][$column]['type']!=$column_data['type'] or
                        $schema_2[$table]['columns'][$column]['default']!=$column_data['default'] or
                        $schema_2[$table]['columns'][$column]['description']!=$column_data['description']
                        )){

                        $matching['correct_column'][$table][$column] = $column_data;

                    }

                }

                /*проявляем сортировку*/
                if(isset($table_data['sortings']) and count($table_data['sortings'])>0){

                    foreach($table_data['sortings'] as $sorting=>$sorting_data){

                        if(
                            !isset($schema_2[$table]['sortings'][$sorting])
                            or json_encode($schema_2[$table]['sortings'][$sorting])!=json_encode($sorting_data)
                        ){
                            $matching[$do.'_sortings'][$table][$sorting] = $sorting_data;
                        }
                    }

                }

                if(isset($table_data['references']) and count($table_data['references'])>0){

                    foreach($table_data['references'] as $reference=>$reference_data){

                        /*проявляем связи*/
                        if(
                            !isset($schema_2[$table]['references'][$reference])
                            or json_encode($schema_2[$table]['references'][$reference])!=json_encode($reference_data)
                        ){
                            $matching[$do.'_reference'][$table][$reference] = $reference_data;
                        }
                    }

                }

            }

        }

        return count($matching)>0 ? $matching : false;
    }

}