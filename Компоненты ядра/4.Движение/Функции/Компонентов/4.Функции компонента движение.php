<?php 

namespace Framework_life_balance\core_components;


class Motion
{

    static function initiation($parameters){

        /*берём настройки протоколов из файла*/
        $config_protocols = Distribution::include_information_from_file([
            'Папка'          => DIR_BUSINESS,
            'Название файла' => 'Настройка протоколов',
            'Тип файла'      => 'php',
        ]);

        if($config_protocols === null){
            self::fix_error([
                'Текст ошибки'          => 'нет файла настройки протоколов',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /*устанавливаем настройки протоколов*/
        Conditions::set_mission([
            'Ключ'     => 'config_protocols',
            'Значение' => $config_protocols,
        ]);

    }

    static function execute_request_experience_goal($parameters){

        /*Вызываем наработку*/
        $result_executed = Motion::call_experience([
            'Наработка'         => Conditions::get_mission(['Ключ' => 'request_experience']),
            'Наработанная цель' => Conditions::get_mission(['Ключ' => 'request_experience_goal']),
            'Параметры'         => Conditions::get_mission(['Ключ' => 'parameters_request']),
        ]);

        /*устанавливаем результат выполнения*/
        Conditions::set_mission([
            'Ключ'     => 'result_executed',
            'Значение' => $result_executed,
        ]);

    }

    static function fix_error($parameters){

        $error_message = $parameters['Текст ошибки'];
        $file_name = $parameters['Файл'];
        $num_line_on_file_error = $parameters['Номер строчки в файле'];
        $stub = $parameters['Заглушка страницы'];

        /*запоминаем при error*/
        if($stub == 'error'){

            /*номер ошибки*/
            $number_crash = Conditions::get_mission([
                'Ключ' => 'number_crash',
            ]) + 1;

            /*устанавливаем номер ошибки*/
            Conditions::set_mission([
                'Ключ'     => 'number_crash',
                'Значение' => $number_crash,
            ]);

            /*устанавливаем ошибку сбоя*/
            Conditions::set_mission([
                'Ключ'     => 'message_crash',
                'Значение' => $error_message,
            ]);

            /*исключаем зацикленность самовызова*/
            if($number_crash==2){

                echo 'Критическая ошибка. Смотрите протокол /Компоненты ядра/4.Дела/Протоколы/Ошибки в ядре.log';

                /*прекращаем работу ядра*/
                Orientation::stop_core([]);

            }

        }

        /*формируем сообщение об ошибке в одну строку*/
        $error_message = trim(str_replace(["\r\n","\n","\r"], ' ', $error_message));

        /*получаем настройки протоколов*/
        $config_protocols = Conditions::get_mission([
            'Ключ' => 'config_protocols',
        ]);

        /*на случай сбоя инициации*/
        if($config_protocols === null){
            $config_protocols['Ошибки ядра'] = true;
        }

        /*запись в протокол нужна*/
        if($config_protocols['Ошибки ядра'] == true){

            $request_experience = Conditions::get_mission([
                'Ключ' => 'request_experience',
            ]);
            $request_experience_goal = Conditions::get_mission([
                'Ключ' => 'request_experience_goal',
            ]);

            $user_ip = Conditions::get_mission([
                'Ключ' => 'user_ip',
            ]);

            $position_time = Orientation::position_time([
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
                'Название файла' => 'Ошибки в ядре',
                'Тип файла'      => 'log',
                'Текст'          => $error_json,
            ]);

        }

        $user_device = Conditions::get_mission([
            'Ключ' => 'user_device',
        ]);

        /* Исключаем зацикленность вызова из консоли*/
        if($user_device == 'console'){

            /*прекращаем работу ядра*/
            Orientation::stop_core([]);

        }

        /*получаем настройки проекта*/
        $config_project = Conditions::get_mission([
            'Ключ' => 'config_project',
        ]);

        /*если нет сбоя инициации*/
        if($config_project != null){

            $request_experience = Conditions::get_mission([
                'Ключ' => 'request_experience',
            ]);
            $request_experience_goal = Conditions::get_mission([
                'Ключ' => 'request_experience_goal',
            ]);

            /*вызываем консоль наработку отправления на почту*/
            Motion::call_console_experience([
                'Наработка'         => 'control',
                'Наработанная цель' => 'send_email',
                'Параметры'         => [
                    'email'    => $config_project['email'],
                    'title'    => 'Ошибка ядра',
                    'text'     => 'По запросу /'.$request_experience.'/'.$request_experience_goal.':<br><b>'.$error_message.'</b>',
                    'template' => 'Норматив блоков mail'.DIRECTORY_SEPARATOR.'message',
                ],
            ]);

        }

        /*выводим заглушку*/
        if($stub){

            /*Вызываем выполнение информирования ошибки или остановки*/
            $result_executed = Motion::call_experience([
                'Наработка'         => 'index',
                'Наработанная цель' => $stub,
                'Параметры'         => [
                    'code'=>$error_message
                ],
            ]);

            /*устанавливаем результат выполнения*/
            Conditions::set_mission([
                'Ключ'     => 'result_executed',
                'Значение' => $result_executed,
            ]);

            /*результат выполнения в интерфейс*/
            Conditions::result_executed_to_interface([]);

            /*Прекращаем работу ядра*/
            Orientation::stop_core([]);

        }

    }

    static function fix_reassembly_data_base($parameters){

        $information = $parameters['Информация'];
        $completed = $parameters['Завершение'];

        if($completed){

            /* Удаляем заглушку */
            Distribution::delete_file([
                'Папка'          => DIR_PROTOCOLS_PROCESSES,
                'Название файла' => 'Текущая реконструкция базы данных',
                'Тип файла'      => 'log',
            ]);

        }
        else{

            /* Протокол */
            Distribution::write_information_in_file([
                'Папка'          => DIR_PROTOCOLS_PROCESSES,
                'Название файла' => 'Текущая реконструкция базы данных',
                'Тип файла'      => 'log',
                'Текст'          => $information,
            ]);
        }

        /* Получаем настройки протоколов */
        $config_protocols = Conditions::get_mission([
            'Ключ' => 'config_protocols',
        ]);

        if($config_protocols['Реконструкции базы данных']){

            /* Протокол */
            Distribution::write_information_in_file([
                'Папка'          => DIR_PROTOCOLS_PROCESSES,
                'Название файла' => 'Реконструкции базы данных',
                'Тип файла'      => 'log',
                'Текст'          => $information,
            ]);

        }


    }

    static function call_experience($parameters){

        $experience = $parameters['Наработка'];
        $experience_goal = $parameters['Наработанная цель'];
        $experience_parameters = $parameters['Параметры'];

        /*устанавливаем вызванную на выполнение наработку*/
        Conditions::set_mission([
            'Ключ'     => 'call_experience',
            'Значение' => $experience,
        ]);

        /*устанавливаем вызванную на выполнение наработанную цель*/
        Conditions::set_mission([
            'Ключ'     => 'call_experience_goal',
            'Значение' => $experience_goal,
        ]);

        /*Помечаем начало выполнения Наработки*/
        Orientation::mark_start_execution_experience([]);

        /* Название класса наработки */
        $experience_class_name = '\Framework_life_balance\core_components\experiences\Category_'.$experience;

        /*проверяем наличие наработанной Цели*/
        if (!method_exists($experience_class_name, $experience_goal)) {
            self::fix_error([
                'Текст ошибки'          => 'no_experience_goal',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /*выполняем наработанную цель*/
        $result_executed = $experience_class_name::$experience_goal($experience_parameters);

        /*Помечаем окончание выполнения Наработки*/
        Orientation::mark_stop_execution_experience([]);

        /*получаем откуда запрос*/
        $user_device = Conditions::get_mission([
            'Ключ' => 'user_device',
        ]);

        if($user_device == 'console' and isset($_SERVER['argv'][3]) and $_SERVER['argv'][3]>0){

            /* Обновляем статус запроса консоли в базе данных */
            Distribution::interchange_information_with_data_base([
                'Направление' => 'Изменение',
                'Чего'        => 'Статуса запуска консоли',
                'Значение'    => [
                    ':id'     => $_SERVER['argv'][3],
                    ':status' => (($result_executed == 'true')?'true':'false'),
                ],
            ]);
        }

        return $result_executed;

    }

    static function call_console_experience($parameters){

        $experience = $parameters['Наработка'];
        $experience_goal = $parameters['Наработанная цель'];
        $experience_parameters = $parameters['Параметры'];

        if(count($parameters)>0){

            $position_time = Orientation::position_time([
                'Формат'  => 'Y-m-d H:i:s',
            ]);

            /* Добавляем запрос консоли в базу данных */
            $id_save_parameters = Distribution::interchange_information_with_data_base([
                'Направление' => 'Добавление',
                'Чего'        => 'Нового запуска из консоли',
                'Значение'    => [
                    ':date'       => $position_time,
                    ':request'    => $experience.'/'.$experience_goal,
                    ':parameters' => json_encode($experience_parameters),
                ],
            ]);

            if($id_save_parameters == false){
                $id_save_parameters = 0;
            }

        }
        else{
            $id_save_parameters = 0;
        }

        /*Формируем консольную консольную команду вызова Наработки*/
        $command = Orientation::formation_console_command_call_experience([
            'Наработка'                            => $experience,
            'Цель'                                 => $experience_goal,
            'Идентификатор сохранённых параметров' => $id_save_parameters,
        ]);

        $operating_system = Conditions::get_mission([
            'Ключ' => 'operating_system',
        ]);

        /*вызов в windows*/
        if ($operating_system == "windows"){
            pclose(popen($command, "r"));
        }
        /*вызов в unix*/
        else{
            exec($command);
        }

    }

    static function work_with_memory_data($parameters){

        $name = $parameters['Обозначение ячейки памяти'];
        $value_update = $parameters['Значение для записи'];
        $time_update = $parameters['Время хранения в сек.'];
        $clear = $parameters['Очистка ячейки'];

        /*получаем значение коммуникации с памятью*/
        $link_communication_with_memory = Conditions::get_mission([
            'Ключ' => 'link_communication_with_memory',
        ]);

        /*доступна ли память*/
        if($link_communication_with_memory == null){
            return false;
        }

        /*записываем данные*/
        if($value_update != false){

            $type_update = 0;

            /*безлимитное время хранения*/
            if($time_update == false){
                $type_update = MEMCACHE_COMPRESSED;
                $time_update = 0;
            }
            /*максимальное возможное время хранения в сек. для установки это 30 дней*/
            elseif($time_update>2592000){
                $time_update = 2592000;
            }

            \memcache_set($link_communication_with_memory,$name, $value_update, $type_update, $time_update);

            $value = $value_update;

        }
        /*выдаём данные*/
        else{
            $value = \memcache_get($link_communication_with_memory,$name);
        }

        /*очищаем*/
        if($clear){
            \memcache_delete($link_communication_with_memory,$name);
        }

        return $value;

    }

    static function data_authorized_user($parameters)
    {

        $detail = $parameters['Показать определенную часть данных'];

        /*получаем значение индификационного номера пользователя*/
        $user_id = Conditions::get_mission([
            'Ключ' => 'user_id',
        ]);

        if($user_id==null){
            return false;
        }

        if(Conditions::get_mission([
            'Ключ' => 'user_data',
        ]) == null){

            /*берём из памяти*/
            $user_data = Motion::work_with_memory_data([
                'Обозначение ячейки памяти' => 'session_'.$user_id,
                'Значение для записи'       => false,
                'Время хранения в сек.'     => false,
                'Очистка ячейки'            => false,
            ]);

            if($user_data){
                /*всё верно*/
                if(isset($user_data['session']) and $user_data['session'] == Conditions::get_mission([
                        'Ключ' => 'user_session',
                    ])){

                    /*устанавливаем значение индификационного номера пользователя*/
                    Conditions::set_mission([
                        'Ключ'     => 'user_data',
                        'Значение' => $user_data,
                    ]);

                }
                /*последняя авторизация была проведена с другого устройства, и эта сессия уже не подходит*/
                else{

                    /*очищаем от значений*/
                    Conditions::delete_mission([
                        'Ключ' => 'user_id',
                    ]);
                    Conditions::delete_mission([
                        'Ключ' => 'user_session',
                    ]);

                    return false;
                }
            }
            /*на случай если в памяти уже нет, берём из базы данных*/
            else{

                $user_data = Distribution::interchange_information_with_data_base([
                    'Направление' => 'Получение',
                    'Чего'        => 'Информации о пользователе по сессии',
                    'Значение'    => [
                        ':id'      => $user_id,
                        ':session' => Conditions::get_mission([
                            'Ключ' => 'user_session',
                        ]),
                    ],
                ]);

                /*всё верно*/
                if($user_data){

                    /*устанавливаем значение индификационного номера пользователя*/
                    Conditions::set_mission([
                        'Ключ'     => 'user_data',
                        'Значение' => $user_data,
                    ]);

                    /* Запоминаем пользователя */
                    Motion::work_with_memory_data([
                        'Обозначение ячейки памяти' => 'session_'.$user_id,
                        'Значение для записи'       => $user_data,
                        'Время хранения в сек.'     => false,
                        'Очистка ячейки'            => false,
                    ]);

                }
                /*последняя авторизация была проведена с другого устройства, и эта сессия уже не подходит*/
                else{

                    /*очищаем от значений*/
                    Conditions::delete_mission([
                        'Ключ' => 'user_id',
                    ]);
                    Conditions::delete_mission([
                        'Ключ' => 'user_session',
                    ]);

                    return false;
                }

            }

        }

        /*получаем значение данных пользователя*/
        $user_data = Conditions::get_mission([
            'Ключ' => 'user_data',
        ]);

        if($detail!=null){
            if(isset($user_data[$detail])){
                return $user_data[$detail];
            }
            else{
                return null;
            }
        }
        else{
            return $user_data;
        }
    }

}