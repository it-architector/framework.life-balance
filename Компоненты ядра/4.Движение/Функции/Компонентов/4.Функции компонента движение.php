<?php 

namespace Framework_life_balance\core_components;

use \Framework_life_balance\core_components\Representation;
use \Framework_life_balance\core_components\Orientation;
use \Framework_life_balance\core_components\Accumulation;

/**
 * Суть дел
 *
 * @package Framework_life_balance\core_components
 *
 */
class Motion
{

    /**
     * Подготавливаем работу с наработками
     *
     * @return null
     */
    static function initiation(){

        /*берём настройки протоколов из файла*/
        $config_protocols = Accumulation::include_information_from_file(DIR_BUSINESS,'Настройка протоколов','php');

        if($config_protocols === null){
            self::fix_error('нет файла настройки протоколов',__FILE__, __LINE__);
        }

        /*устанавливаем настройки протоколов*/
        Representation::set_mission('config_protocols',$config_protocols);

    }

    /*---------------------------------------------------------*/
    /*------------------------ДЕЙСТВИЕ-------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Выполняем запрошенную наработанную цель
     *
     * @return null
     */
    static function execute_request_experience_goal(){

        /*Вызываем наработку*/
        $result_executed = Motion::call_experience(
            Representation::get_mission('request_experience'),
            Representation::get_mission('request_experience_goal'),
            Representation::get_mission('parameters_request')
        );

        /*устанавливаем результат выполнения*/
        Representation::set_mission('result_executed',$result_executed);

    }

    /**
     * Фиксируем ошибку
     *
     * @param string $error_message текст ошибки
     * @param string $file_name файл где произошла ошибка
     * @param string $num_line_on_file_error номер строчки в файле где произошла ошибка
     * @param string|false $stub заглушка страницы
     * @return null
     */
    static function fix_error($error_message, $file_name = null, $num_line_on_file_error = null, $stub = 'error'){

        /*запоминаем при error*/
        if($stub == 'error'){

            /*номер ошибки*/
            $number_crash = Representation::get_mission('number_crash') + 1;

            /*устанавливаем номер ошибки*/
            Representation::set_mission('number_crash',$number_crash);

            /*устанавливаем ошибку сбоя*/
            Representation::set_mission('message_crash',$error_message);

            /*исключаем зацикленность самовызова*/
            if($number_crash==2){

                echo 'Критическая ошибка. Смотрите протокол /Компоненты ядра/4.Дела/Протоколы/Ошибки в ядре.log';

                /*прекращаем работу ядра*/
                Orientation::stop_core();

            }

        }

        /*формируем сообщение об ошибке в одну строку*/
        $error_message = trim(str_replace(["\r\n","\n","\r"], ' ', $error_message));

        /*получаем настройки протоколов*/
        $config_protocols = Representation::get_mission('config_protocols');

        /*на случай сбоя инициации*/
        if($config_protocols === null){
            $config_protocols['Ошибки ядра'] = true;
        }

        /*запись в протокол нужна*/
        if($config_protocols['Ошибки ядра'] == true){

            /*записываем ошибку в файл*/
            Accumulation::write_information_in_file(DIR_PROTOCOLS_PROCESSES,'Ошибки в ядре','log',
                'request ('.Representation::get_mission('request_experience').'/'.Representation::get_mission('request_experience_goal').'): '.explode("\n",$error_message)[0]
                .' | user ip: '.Representation::get_mission('user_ip')
                .(($file_name!=null)?' | file name: ' . $file_name:'')
                .(($num_line_on_file_error!=null)?' | file line: ' . $num_line_on_file_error:''));

        }

        /* Исключаем зацикленность вызова из консоли*/
        if(Representation::get_mission('user_device') == 'console'){

            /*прекращаем работу ядра*/
            Orientation::stop_core();

        }

        /*получаем настройки проекта*/
        $config_project = Representation::get_mission('config_project');

        /*если нет сбоя инициации*/
        if($config_project != null){

            /*вызываем консоль наработку отправления на почту*/
            Motion::call_console_experience('control', 'send_email', [
                'email'    => $config_project['email'],
                'title'    => 'Ошибка ядра',
                'text'     => 'По запросу /'.Representation::get_mission('request_experience').'/'.Representation::get_mission('request_experience_goal').':<br><b>'.$error_message.'</b>',
                'template' => 'Норматив блоков mail'.DIRECTORY_SEPARATOR.'message',
            ]);

        }

        /*выводим заглушку*/
        if($stub){

            /*Вызываем выполнение информирования ошибки или остановки*/
            $result_executed = Motion::call_experience('index', $stub, ['code'=>$error_message]);

            /*устанавливаем результат выполнения*/
            Representation::set_mission('result_executed',$result_executed);

            /*результат выполнения в интерфейс*/
            Representation::result_executed_to_interface();

            /*Прекращаем работу ядра*/
            Orientation::stop_core();

        }

    }

    /**
     * Фиксируем реконструкцию базы данных
     *
     * @param string $information информация
     * @param boolean $completed завершение
     * @return null
     */
    static function fix_reassembly_data_base($information, $completed = false){

        if($completed){

            /* Удаляем заглушку */
            Accumulation::delete_file(DIR_PROTOCOLS_PROCESSES, 'Текущая реконструкция базы данных','log');

        }
        else{

            /* Протокол */
            Accumulation::write_information_in_file(
                DIR_PROTOCOLS_PROCESSES, 'Текущая реконструкция базы данных','log',
                $information
            );
        }

        /* Получаем настройки протоколов */
        $config_protocols = Representation::get_mission('config_protocols');

        if($config_protocols['Реконструкции базы данных']){

            /* Протокол */
            Accumulation::write_information_in_file(
                DIR_PROTOCOLS_PROCESSES, 'Реконструкции базы данных','log', $information);

        }


    }

    /*---------------------------------------------------------*/
    /*----------------------ДЕЛЕГИРОВАНИЕ----------------------*/
    /*---------------------------------------------------------*/

    /**
     * Вызываем наработку
     *
     * @param string $experience наработка
     * @param string $experience_goal наработанная цель
     * @param array $parameters параметры
     * @return null
     */
    static function call_experience($experience, $experience_goal, array $parameters){

        /*устанавливаем вызванную на выполнение наработку*/
        Representation::set_mission('call_experience',$experience);

        /*устанавливаем вызванную на выполнение наработанную цель*/
        Representation::set_mission('call_experience_goal',$experience_goal);

        /*Помечаем начало выполнения Наработки*/
        Orientation::mark_start_execution_experience();

        /* Название класса наработки */
        $experience_class_name = '\Framework_life_balance\core_components\experiences\Category_'.$experience;

        /*проверяем наличие наработанной Цели*/
        if (!method_exists($experience_class_name, $experience_goal)) {
            self::fix_error('no_experience_goal',__FILE__, __LINE__);
        }

        /*выполняем наработанную цель*/
        $result_executed = $experience_class_name::$experience_goal($parameters);

        /*Помечаем окончание выполнения Наработки*/
        Orientation::mark_stop_execution_experience();

        /*получаем откуда запрос*/
        $user_device = Representation::get_mission('user_device');

        if($user_device == 'console' and isset($_SERVER['argv'][3]) and $_SERVER['argv'][3]>0){

            /* Обновляем статус запроса консоли в базе данных */
            Accumulation::interchange_information_with_data_base('Изменение', 'Статуса запуска консоли', [
                ':id'     => $_SERVER['argv'][3],
                ':status' => (($result_executed == 'true')?'true':'false'),
            ]);
        }

        return $result_executed;

    }

    /**
     * Вызываем консольную наработку
     *
     * @param string $experience наработка
     * @param string $experience_goal цель
     * @param array $parameters параметры
     * @return null
     */
    static function call_console_experience($experience, $experience_goal, array $parameters){

        if(count($parameters)>0){

            /* Добавляем запрос консоли в базу данных */
            $id_save_parameters = Accumulation::interchange_information_with_data_base('Добавление', 'Нового запуска из консоли', [
                ':date'       => Orientation::position_time(),
                ':request'    => $experience.'/'.$experience_goal,
                ':parameters' => json_encode($parameters),
            ]);

            if($id_save_parameters == false){
                $id_save_parameters = 0;
            }

        }
        else{
            $id_save_parameters = 0;
        }

        /*Формируем консольную консольную команду вызова Наработки*/
        $command = Orientation::formation_console_command_call_experience($experience, $experience_goal, $id_save_parameters);

        /*вызов в windows*/
        if (Representation::get_mission('operating_system') == "windows"){
            pclose(popen($command, "r"));
        }
        /*вызов в unix*/
        else{
            exec($command);
        }

    }

    /*---------------------------------------------------------*/
    /*------------------------ПАМЯТЬ---------------------------*/
    /*---------------------------------------------------------*/

    /**
     * Работаем с оперативной памятью
     *
     * @param string $name обозначение ячейки памяти
     * @param string|integer|array|boolean $value_update значение для записи
     * @param integer|boolean $time_update время хранения в сек.
     * @param boolean $clear очистка ячейки
     * @return string|integer|array $value
     */
    static function work_with_memory_data($name, $value_update=false, $time_update=false, $clear = false){

        /*получаем значение коммуникации с памятью*/
        $link_communication_with_memory = Representation::get_mission('link_communication_with_memory');

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

    /**
     * Данные авторизованного пользователя
     *
     * @param string $detail показать определенную часть данных
     * @return array|string|boolean
     */
    static function data_authorized_user($detail=null)
    {
        /*получаем значение индификационного номера пользователя*/
        $user_id = Representation::get_mission('user_id');

        if($user_id==null){
            return false;
        }

        if(Representation::get_mission('user_data') == null){

            /*берём из памяти*/
            $user_data = Motion::work_with_memory_data('session_'.$user_id);

            if($user_data){
                /*всё верно*/
                if(isset($user_data['session']) and $user_data['session'] == Representation::get_mission('user_session')){

                    /*устанавливаем значение индификационного номера пользователя*/
                    Representation::set_mission('user_data',$user_data);

                }
                /*последняя авторизация была проведена с другого устройства, и эта сессия уже не подходит*/
                else{

                    /*очищаем от значений*/
                    Representation::delete_mission('user_id');
                    Representation::delete_mission('user_session');

                    return false;
                }
            }
            /*на случай если в памяти уже нет, берём из базы данных*/
            else{

                $user_data = Accumulation::interchange_information_with_data_base('Получение', 'Информации о пользователе по сессии', [
                    ':id'      => $user_id,
                    ':session' => Representation::get_mission('user_session'),
                ]);

                /*всё верно*/
                if($user_data){

                    /*устанавливаем значение индификационного номера пользователя*/
                    Representation::set_mission('user_data',$user_data);

                }
                /*последняя авторизация была проведена с другого устройства, и эта сессия уже не подходит*/
                else{

                    /*очищаем от значений*/
                    Representation::delete_mission('user_id');
                    Representation::delete_mission('user_session');

                    return false;
                }

            }

        }

        /*получаем значение данных пользователя*/
        $user_data = Representation::get_mission('user_data');

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