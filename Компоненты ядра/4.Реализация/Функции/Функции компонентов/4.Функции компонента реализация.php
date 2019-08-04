<?php 

namespace Framework_life_balance\core_components;


class Realization
{

    static function initiation($parameters){

        /* Включаем контроль ядра */
        Conditions::initiation([]);

        /* Определяем вывод информации */
        Space::initiation([]);

        /* Подготавливаем работу с ресурсами */
        Distribution::initiation([]);

        /* Разбираем запрос */
        Conditions::parse_request([]);

        /* Разбираем авторизованность */
        Conditions::parse_authorized([]);

        /* Проверяем запрос на правомерность */
        Conditions::check_request_legality([]);

        /* Создаем комуникацию с памятью */
        Distribution::create_communication_with_memory([]);

        /* Проверяем изменения в схеме базы данных */
        Conditions::check_changes_schema_data_base([]);

        /* Создаем комуникацию с базой данных */
        Distribution::create_communication_with_data_base([]);

        /* Проверяем запрос на доступность */
        Conditions::check_request_access([]);

        /* Разбираем параметры запроса */
        Conditions::parse_parameters_request([]);

        /* Проверяем запрос на деструктив */
        Conditions::check_request_destructive([]);

        /* Выполняем запрошенную наработанную цель */
        Realization::execute_request_experience_goal([]);

        /* Проверяем ответ на правильность */
        Conditions::check_answer_correct([]);

        /* Результат выполнения в интерфейс */
        Realization::result_executed_to_interface([]);

        /* Прекращаем работу ядра */
        Conditions::stop_core([]);

    }

    static function execute_request_experience_goal($parameters){

        /*Вызываем наработку*/
        $result_executed = Realization::call_experience([
            'Наработка'         => Space::get_mission(['Ключ' => 'request_experience']),
            'Наработанная цель' => Space::get_mission(['Ключ' => 'request_experience_goal']),
            'Параметры'         => Space::get_mission(['Ключ' => 'parameters_request']),
        ]);

        /*устанавливаем результат выполнения*/
        Space::set_mission([
            'Ключ'     => 'result_executed',
            'Значение' => $result_executed,
        ]);

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
        $config_system = Space::get_mission([
            'Ключ' => 'config_system',
        ]);

        if($config_system['Реконструкции базы данных']){

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
        Space::set_mission([
            'Ключ'     => 'call_experience',
            'Значение' => $experience,
        ]);

        /*устанавливаем вызванную на выполнение наработанную цель*/
        Space::set_mission([
            'Ключ'     => 'call_experience_goal',
            'Значение' => $experience_goal,
        ]);

        /*Помечаем начало выполнения Наработки*/
        Conditions::mark_start_execution_experience([]);

        /* Название класса наработки */
        $experience_class_name = '\Framework_life_balance\core_components\experiences\Category_'.$experience;

        /*проверяем наличие наработанной Цели*/
        if (!method_exists($experience_class_name, $experience_goal)) {
            self::fix_claim([
                'Претензия'          => 'no_experience_goal',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /*выполняем наработанную цель*/
        $result_executed = $experience_class_name::$experience_goal($experience_parameters);

        /*Помечаем окончание выполнения Наработки*/
        Conditions::mark_stop_execution_experience([]);

        /*получаем откуда запрос*/
        $user_device = Space::get_mission([
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

            $position_time = Conditions::position_time([
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
        $command = Conditions::formation_console_command_call_experience([
            'Наработка'                            => $experience,
            'Цель'                                 => $experience_goal,
            'Идентификатор сохранённых параметров' => $id_save_parameters,
        ]);

        $operating_system = Space::get_mission([
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
        $link_communication_with_memory = Space::get_mission([
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
        $user_id = Space::get_mission([
            'Ключ' => 'user_id',
        ]);

        if($user_id==null){
            return false;
        }

        if(Space::get_mission([
            'Ключ' => 'user_data',
        ]) == null){

            /*берём из памяти*/
            $user_data = Realization::work_with_memory_data([
                'Обозначение ячейки памяти' => 'session_'.$user_id,
                'Значение для записи'       => false,
                'Время хранения в сек.'     => false,
                'Очистка ячейки'            => false,
            ]);

            if($user_data){
                /*всё верно*/
                if(isset($user_data['session']) and $user_data['session'] == Space::get_mission([
                        'Ключ' => 'user_session',
                    ])){

                    /*устанавливаем значение индификационного номера пользователя*/
                    Space::set_mission([
                        'Ключ'     => 'user_data',
                        'Значение' => $user_data,
                    ]);

                }
                /*последняя авторизация была проведена с другого устройства, и эта сессия уже не подходит*/
                else{

                    /*очищаем от значений*/
                    Space::delete_mission([
                        'Ключ' => 'user_id',
                    ]);
                    Space::delete_mission([
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
                        ':session' => Space::get_mission([
                            'Ключ' => 'user_session',
                        ]),
                    ],
                ]);

                /*всё верно*/
                if($user_data){

                    /*устанавливаем значение индификационного номера пользователя*/
                    Space::set_mission([
                        'Ключ'     => 'user_data',
                        'Значение' => $user_data,
                    ]);

                    /* Запоминаем пользователя */
                    Realization::work_with_memory_data([
                        'Обозначение ячейки памяти' => 'session_'.$user_id,
                        'Значение для записи'       => $user_data,
                        'Время хранения в сек.'     => false,
                        'Очистка ячейки'            => false,
                    ]);

                }
                /*последняя авторизация была проведена с другого устройства, и эта сессия уже не подходит*/
                else{

                    /*очищаем от значений*/
                    Space::delete_mission([
                        'Ключ' => 'user_id',
                    ]);
                    Space::delete_mission([
                        'Ключ' => 'user_session',
                    ]);

                    return false;
                }

            }

        }

        /*получаем значение данных пользователя*/
        $user_data = Space::get_mission([
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

    static function result_executed_to_interface($parameters){

        /* Формируем ответ */
        $answer = Conditions::formation_result_executed_to_interface([]);

        /* Выводим ответ */
        echo $answer;

    }

    static function message_to_mail($parameters){

        $email = $parameters['Электронный адрес получателя'];
        $title = $parameters['Заголовок'];
        $text = $parameters['Текст'];
        $template = $parameters['Шаблон'];

        /* Получаем ссылку на коммуникацию с почтой */
        $link_communication_with_mail = Space::get_mission([
            'Ключ' => 'link_communication_with_mail',
        ]);

        /* Проверяем ссылку на коммуникацию с почтой */
        if($link_communication_with_mail == null){
            return false;
        }

        try {

            /* Получаем настройки проекта */
            $config_project = Space::get_mission([
                'Ключ' => 'config_project',
            ]);

            /* От кого письмо */
            $link_communication_with_mail->setFrom($config_project['email'], $config_project['name']);

            /* Кому письмо */
            $link_communication_with_mail->addAddress($email);

            /* Формируем содержимое */

            $link_communication_with_mail->isHTML(true);
            $link_communication_with_mail->Subject = $title;
            $link_communication_with_mail->Body    = Conditions::formation_template([
                'Шаблон'    => $template,
                'Параметры' => [
                    'TITLE'        => $title,
                    'TEXT'         => $text,
                    'PROJECT_NAME' => $config_project['name'],
                    'PROJECT_URL'  => Conditions::formation_url_project([]),
                ],
            ]);
            $link_communication_with_mail->AltBody = strip_tags($text);

            /* Отправляем почту */
            $link_communication_with_mail->send();

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /* Удаляем коммуникацию с почтой */
            Space::delete_mission([
                'Ключ' => 'link_communication_with_mail',
            ]);

            /* Фиксируем ошибку */
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

}