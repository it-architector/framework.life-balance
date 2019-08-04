<?php

namespace Framework_life_balance\core_components;

use \Framework_life_balance\core_components\their_modules\Data_Base;
use \PHPMailer\PHPMailer\PHPMailer;

class Distribution
{

    static function initiation($parameters)
    {

        /* Получаем настройки коммуникаций из файла */
        $config_communications = Distribution::include_information_from_file([
            'Папка'          => DIR_DISTRIBUTION,
            'Название файла' => 'Настройка коммуникаций',
            'Тип файла'      => 'php',
        ]);

        if($config_communications === null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла настройки коммуникаций',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем настройки коммуникаций */
        Space::set_mission([
            'Ключ'     => 'config_communications',
            'Значение' => $config_communications,
        ]);

        /* Получаем схему наработок из файла */
        $schema_experiences = Distribution::include_information_from_file([
            'Папка'          => DIR_STRUCTURES,
            'Название файла' => '4.Структура функций сайта',
            'Тип файла'      => 'php',
        ]);

        if($schema_experiences === null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла Элементыа функций сайта',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем схему наработок */
        Space::set_mission([
            'Ключ'     => 'schema_experiences',
            'Значение' => $schema_experiences,
        ]);

        /* Получаем схему базы данных из файла */
        $schema_data_base = Distribution::include_information_from_file([
            'Папка'          => DIR_STRUCTURES,
            'Название файла' => '3.Структура таблиц базы данных',
            'Тип файла'      => 'php',
        ]);

        if($schema_data_base === null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла Элементыа таблиц базы данных',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем схему базы данных */
        Space::set_mission([
            'Ключ'     => 'schema_data_base',
            'Значение' => $schema_data_base,
        ]);

        /* Получаем схему взаимодействия с базой данных */
        $schema_interaction_with_data_base = Distribution::include_information_from_file([
            'Папка'          => DIR_ITEMS,
            'Название файла' => '2.Элементы базы данных',
            'Тип файла'      => 'php',
        ]);

        if($schema_interaction_with_data_base === null){
            Conditions::fix_claim([
                'Претензия'          => 'нет файла Элементыа взаимодействия с базой данных',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Устанавливаем схему взаимодействия с базой данных */
        Space::set_mission([
            'Ключ'     => 'schema_interaction_with_data_base',
            'Значение' => $schema_interaction_with_data_base,
        ]);

    }

    static function schema_experience($parameters)
    {

        $experience = $parameters['Наработка'];
        $goal = $parameters['Цель'];
        $detail = $parameters['Деталь'];

        /*Проверяем правильное взятие Элементыа наработок*/
        Conditions::check_correct_taking_schema_experience([
            'Наработка' => $experience,
            'Цель'      => $goal,
            'Деталь'    => $detail,
            'Заглушка'  => 'error',
        ]);

        /*получаем схему наработок*/
        $schema_experiences = Space::get_mission([
            'Ключ' => 'schema_experiences',
        ]);

        /*получаем данные на цель*/
        if($experience!== null and $goal !== null){

            if($detail !== null){
                return $schema_experiences[$experience]['goals'][$goal][$detail];
            }
            else{
                return $schema_experiences[$experience]['goals'][$goal];
            }
        }
        /*получаем данные на наработку*/
        elseif($experience !== null){

            if($detail !== null){
                return $schema_experiences[$experience][$detail];
            }
            else{
                return $schema_experiences[$experience];
            }
        }
        /*выдаём всё*/
        else{
            return $schema_experiences;
        }

    }

    static function schema_data_base($parameters)
    {

        $table = $parameters['Показать данные определенной таблицы'];
        $column = $parameters['Показать данные определенной колонки'];
        $detail = $parameters['Деталь'];

        /*Проверяем правильное взятие Элементыа базы данных*/
        Conditions::check_correct_taking_schema_data_base([
            'Таблица'   => $table,
            'Колонка'   => $column,
            'Деталь'    => $detail,
            'Заглушка'  => 'error',
        ]);

        /*получаем схему базы данных*/
        $schema_data_base = Space::get_mission([
            'Ключ' => 'schema_data_base',
        ]);

        /*получаем данные на цель*/
        if($table!=null and $column!=null){

            if($detail != null){
                return $schema_data_base[$table]['columns'][$column][$detail];
            }
            else{
                return $schema_data_base[$table]['columns'][$column];
            }
        }
        /*получаем данные на наработку*/
        elseif($table!=null){

            if($detail != null){
                return $schema_data_base[$table][$detail];
            }
            else{
                return $schema_data_base[$table];
            }
        }
        /*выдаём всё*/
        else{
            return $schema_data_base;
        }

    }

    static function save_realized_schema_data_base($parameters){

        $realized_schema = $parameters['Реализованная схема'];

        self::write_information_in_file([
            'Папка'          => DIR_RESULTS,
            'Название файла' => 'Реализованный объём таблиц базы данных',
            'Тип файла'      => 'php',
            'Текст'          => '<?php'."\n".' return '.var_export($realized_schema, true).'; ?>',
        ]);

    }

    static function get_information_realized_schema_data_base($parameters){

        $realized_schema = self::include_information_from_file([
            'Папка'          => DIR_RESULTS,
            'Название файла' => 'Реализованный объём таблиц базы данных',
            'Тип файла'      => 'php',
        ]);

        return is_array($realized_schema) ? $realized_schema : [];

    }

    static function create_communication_with_data_base($parameters){

        /*получаем настройки системы*/
        $config_system = Space::get_mission([
            'Ключ' => 'config_system',
        ]);

        /*включено ли*/
        if(!$config_system['inclusiveness_data_base']){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => 'no class Data_Base',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /*получаем настройки ппроекта*/
        $config_project = Space::get_mission([
            'Ключ' => 'config_project',
        ]);

        /*получаем настройки коммуникаций*/
        $config_communications = Space::get_mission([
            'Ключ' => 'config_communications',
        ]);

        try{

            /*получаем настройки протоколов*/
            $config_system = Space::get_mission([
                'Ключ' => 'config_system',
            ]);

            /*запись взаимодействий с базой данных в файл лога */
            if($config_system['Запросы в базу данных']){
                $file_log = DIR_PROTOCOLS_PROCESSES . 'Запросы в базу данных.log';
            }
            else{
                $file_log = null;
            }

            /*подключаемся к базе данных*/
            Data_Base::create_communication_with_data_base(
                $config_communications['data_base']['host'],
                $config_communications['data_base']['name'],
                $config_communications['data_base']['schema'],
                $config_communications['data_base']['access']['user'],
                $config_communications['data_base']['access']['password'],
                $file_log
            );

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

    static function complete_communication_with_data_base($parameters){

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        try{
            /*Завершаем коммуникацию с базой данных*/
            $result = Data_Base::complete_communication_with_data_base();

            return $result;
        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

    static function create_communication_with_memory($parameters){

        /*получаем настройки системы*/
        $config_system = Space::get_mission([
            'Ключ' => 'config_system',
        ]);

        /*включено ли*/
        if(!$config_system['inclusiveness_memory']){
            return false;
        }

        /*получаем настройки коммуникации*/
        $config_communications = Space::get_mission([
            'Ключ' => 'config_communications',
        ]);

        /*есть ли настройки*/
        if(!isset($config_communications['memory'])){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('Memcache')){
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => 'no install/start memcache',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        try{

            $link_communication_with_memory = \memcache_connect(
                $config_communications['memory']['host'],
                $config_communications['memory']['port']
            );

            /*устанавливаем ссылку на коммуникацию с памятью*/
            Space::set_mission([
                'Ключ'     => 'link_communication_with_memory',
                'Значение' => $link_communication_with_memory,
            ]);

        }catch ( \Exception $e ) {
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

    static function complete_communication_with_memory($parameters){

        /*получаем ссылку на коммуникацию с памятью*/
        $link_communication_with_memory = Space::get_mission([
            'Ключ' => 'link_communication_with_memory',
        ]);

        if($link_communication_with_memory == null){
            return false;
        }

        \memcache_close($link_communication_with_memory);

        /*Обнуляем ссылку на коммуникацию с памятью*/
        Space::delete_mission([
            'Ключ' => 'link_communication_with_memory',
        ]);

        return true;

    }

    static function create_communication_with_mail($parameters){

        /*получаем настройки системы*/
        $config_system = Space::get_mission([
            'Ключ' => 'config_system',
        ]);

        /*включено ли*/
        if(!$config_system['inclusiveness_mail']){
            return false;
        }

        /*подключен ли класс для работы*/
        if(!class_exists('\PHPMailer\PHPMailer\PHPMailer')){
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => 'no class PHPMailer',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /*получаем настройки ппроекта*/
        $config_project = Space::get_mission([
            'Ключ' => 'config_project',
        ]);

        /*получаем настройки коммуникации*/
        $config_communications = Space::get_mission([
            'Ключ' => 'config_communications',
        ]);

        try {


            $mail = new PHPMailer(true);

            /*настраиваем*/
            $mail->SMTPDebug = 0;
            $mail->CharSet = "UTF-8";
            $mail->Timeout = 3;
            $mail->isSMTP();
            $mail->Host = $config_communications['mail']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config_communications['mail']['access']['login'];
            $mail->Password = $config_communications['mail']['access']['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $config_communications['mail']['port'];

            /*для портов 587 настройка работы с сертификатом*/
            if($config_communications['mail']['port']==587){
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }
            /*получаем настройки проекта*/
            $config_project = Space::get_mission([
                'Ключ' => 'config_project',
            ]);

            /*от кого письмо*/
            $mail->setFrom($config_project['email'], $config_project['name']);

            /*устанавливаем ссылку на коммуникацию с почтой*/
            Space::set_mission([
                'Ключ'     => 'link_communication_with_mail',
                'Значение' => $mail,
            ]);

            return true;

        }
        catch (\PHPMailer\PHPMailer\Exception $e) {

            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => $mail->ErrorInfo,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

    static function complete_communication_with_mail($parameters){

        /*получаем ссылку на коммуникацию с почтой*/
        $link_communication_with_mail = Space::get_mission([
            'Ключ' => 'link_communication_with_mail',
        ]);

        if($link_communication_with_mail == null){
            return false;
        }

        /*Обнуляем ссылку на коммуникацию с почтой*/
        Space::delete_mission([
            'Ключ' => 'link_communication_with_mail',
        ]);

        return true;

    }

    static function write_information_in_file($parameters){

        $dir = $parameters['Папка'];
        $name = $parameters['Название файла'];
        $type = $parameters['Тип файла'];
        $information = $parameters['Текст'];

        if($type == 'log'){

            $information = $information . "\r\n";
            /*дозапись*/
            $addition = true;
        }
        elseif($type == 'md'){
                /*дозапись*/
                $addition = true;
            }
        else{
            /*дозапись*/
            $addition = false;
        }

        file_put_contents(
            $dir . $name . '.' . $type,
            $information,
            $addition ? FILE_APPEND : null
        );
    }

    static function include_information_from_file($parameters){

        $dir = $parameters['Папка'];
        $name = $parameters['Название файла'];
        $type = $parameters['Тип файла'];

        /*путь к файлу*/
        $patch_file =  $dir . $name . '.'.$type;

        /*проверяем файл*/
        if (!file_exists($patch_file)) {
            return null;
        }

        if($type == 'php'){

            /*подлючаем файл*/
            return include $patch_file;

        }
        elseif($type == 'log'){

            /*читаем файл*/
            return file($patch_file);

        }
        elseif($type == 'html'){

            /*читаем файл*/
            return file_get_contents($patch_file);

        }
        else{
            return null;
        }

    }

    static function delete_file($parameters){

        $dir = $parameters['Папка'];
        $name = $parameters['Название файла'];
        $type = $parameters['Тип файла'];

        /*путь к файлу*/
        $patch_file =  $dir . $name . '.'.$type;

        /*проверяем наличие файла*/
        if (!file_exists($patch_file)) {
            return false;
        }

        /*удаляем файл*/
        unlink($patch_file);

    }

    static function interchange_information_with_data_base($parameters){

        $direction = $parameters['Направление'];
        $what = $parameters['Чего'];
        $values = $parameters['Значение'];

        /* Получаем схему взаимодействия с базой данных */
        $schema_interaction_with_data_base = Space::get_mission([
            'Ключ' => 'schema_interaction_with_data_base',
        ]);

        if($schema_interaction_with_data_base == null){
            return false;
        }

        if(!isset($schema_interaction_with_data_base[$direction])){
            /* Фиксируем ошибку */
            Conditions::fix_claim([
                'Претензия'          => 'Не известно направление "'.$direction.'" во взаимодействии с базой данных',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }
        elseif(!isset($schema_interaction_with_data_base[$direction][$what])){
            /* Фиксируем ошибку */
            Conditions::fix_claim([
                'Претензия'          => 'Не известно чего "'.$what.'" направления "'.$direction.'" во взаимодействии с базой данных',
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

        /* Информация запроса */
        $information_query = $schema_interaction_with_data_base[$direction][$what];

        try{

            if($direction == 'Добавление'){

                $key = Data_Base::call_add_information(
                    $information_query['Таблица'],
                    $information_query['Передачи'],
                    $values
                );

                return $key;

            }
            elseif($direction == 'Количество'){

                $count = Data_Base::call_count_information(
                    $information_query['Таблица'],
                    $information_query['Уточнение'],
                    $values
                );

                return $count;

            }
            elseif($direction == 'Получение'){

                $data = Data_Base::call_get_information(
                    $information_query['Таблица'],
                    $information_query['Получение'],
                    $information_query['Уточнение'],
                    $information_query['Сортировка'],
                    $information_query['Позиция'],
                    $information_query['Количество'],
                    $values
                );

                return $data;

            }
            elseif($direction == 'Изменение'){

                $updated = Data_Base::call_update_information(
                    $information_query['Таблица'],
                    $information_query['Передачи'],
                    $information_query['Уточнение'],
                    $information_query['Количество'],
                    $values
                );

                return $updated;

            }
            elseif($direction == 'Удаление'){

                $deleted = Data_Base::call_delete_information(
                    $information_query['Таблица'],
                    $information_query['Уточнение'],
                    $information_query['Количество'],
                    $values
                );

                return $deleted;

            }
            else{
                /* Фиксируем ошибку */
                Conditions::fix_claim([
                    'Претензия'          => 'Не известно направление "'.$direction.'" во взаимодействии с базой данных',
                    'Файл'                  => __FILE__,
                    'Номер строчки в файле' => __LINE__,
                    'Заглушка страницы'     => 'error',
                ]);
            }

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage(),
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }

    static function reconstruction_data_base($parameters){

        $changes = $parameters['Изменения'];

        /*подключен ли класс для работы*/
        if(!class_exists('\Framework_life_balance\core_components\their_modules\Data_Base')){
            return false;
        }

        /*инструкция когда случилась ошибка*/
        $instruction_when_error = '<br><br>Когда поправите код, вручную запустите в консоли команду: php Ядро.php control reassembly_data_base';

        /*последовательность применения изменений*/
        $sequence_changes = [
            'delete_reference',
            'delete_sortings',
            'delete_column',
            'delete_table',

            'correct_comment_table',
            'correct_primary_column_table',
            'correct_column',

            'create_table',
            'create_column',
            'create_sortings',
            'create_reference',
        ];

        /* Реализованный объём таблиц базы данных */
        $realized_schema = Distribution::get_information_realized_schema_data_base([]);

        try{

            foreach($sequence_changes as $change){
                if(isset($changes[$change]) and count($changes[$change])>0){

                    if($change == 'create_table'){

                        foreach($changes[$change] as $table => $table_change){

                            /*Вызываем создание Структуры таблицы*/
                            Data_Base::call_create_structure_table(
                                $table,
                                $table_change['description'],
                                $table_change['primary_column'],
                                $table_change['primary_column_data']['type'],
                                $table_change['primary_column_data']['default'],
                                $table_change['primary_column_data']['description']
                            );

                            /*заполняем реализованное*/
                            $realized_schema[$table]['description'] = $table_change['description'];
                            $realized_schema[$table]['primary_column'] = $table_change['primary_column'];
                            $realized_schema[$table]['columns'][$table_change['primary_column']] = [
                                'type'        => $table_change['primary_column_data']['type'],
                                'default'     => $table_change['primary_column_data']['default'],
                                'description' => $table_change['primary_column_data']['description'],
                            ];

                            /*сохраняем схему реализованного*/
                            self::save_realized_schema_data_base([
                                'Реализованная схема' => $realized_schema,
                            ]);

                            /* Фиксируем реконструкцию базы данных */
                            Realization::fix_reassembly_data_base([
                                'Информация' => 'Создана таблица '.$table,
                                'Завершение' => false,
                            ]);

                        }

                    }
                    elseif($change == 'create_column'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $column_change){

                                /*Вызываем создание Структуры колонки*/
                                Data_Base::call_create_structure_column(
                                    $table,
                                    $column,
                                    $column_change['type'],
                                    $column_change['default'],
                                    $column_change['description']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['columns'][$column] = [
                                    'description' => $column_change['description'],
                                    'type'    => $column_change['type'],
                                    'default' => $column_change['default'],
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Создана колонка '.$column.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }
                    }
                    elseif($change == 'create_sortings'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $sorting => $sorting_change){

                                /*Вызываем создание Структуры сортировки*/
                                Data_Base::call_create_structure_sorting(
                                    $table,
                                    $sorting,
                                    $sorting_change['unique'],
                                    $sorting_change['columns']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['sortings'][$sorting] = [
                                    'description' => $sorting_change['description'],
                                    'unique'   => $sorting_change['unique'],
                                    'columns'  => $sorting_change['columns']
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Создана сортировка '.$sorting.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }
                    }
                    elseif($change == 'create_reference'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $reference_change){

                                /*проверяем соотвествие типов колонок*/
                                if($realized_schema[$table]['columns'][$column]['type'] != $realized_schema[$reference_change['table']]['columns'][$reference_change['column']]['type']){
                                    Conditions::fix_claim([
                                        'Претензия'          => 'нет возможности создать связь у колонок '.$table.'.'.$column.' ('.$realized_schema[$table]['columns'][$column]['type'].') и '.$reference_change['table'].'.'.$reference_change['column'].' ('.$realized_schema[$reference_change['table']]['columns'][$reference_change['column']]['type'].') по причине разных типов колонок' . $instruction_when_error,
                                        'Файл'                  => __FILE__,
                                        'Номер строчки в файле' => __LINE__,
                                        'Заглушка страницы'     => 'error',
                                    ]);
                                }

                                /*Вызываем создание Структуры связи*/
                                Data_Base::call_create_structure_reference(
                                    $table,
                                    $column,
                                    $realized_schema[$table]['columns'][$column]['default'],
                                    $reference_change['table'],
                                    $reference_change['column'],
                                    $reference_change['update'],
                                    $reference_change['delete']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['references'][$column] = [
                                    'table'  => $reference_change['table'],
                                    'column' => $reference_change['column'],
                                    'update' => $reference_change['update'],
                                    'delete' => $reference_change['delete']
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Создана связь колонке '.$column.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }

                    }
                    elseif($change == 'delete_reference'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $reference_change){

                                /*Вызываем удаления Структуры связи*/
                                Data_Base::call_delete_structure_reference(
                                    $table,
                                    $column,
                                    $reference_change['table'],
                                    $reference_change['column']
                                );

                                /*удаляем из реализованного*/
                                unset($realized_schema[$table]['references'][$column]);

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Удалена связь колонке '.$column.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }

                    }
                    elseif($change == 'delete_sortings'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $sorting => $sorting_change){

                                /*Вызываем удаление Структуры сортировки*/
                                Data_Base::call_delete_structure_sorting(
                                    $table,
                                    $sorting,
                                    $sorting_change['unique']
                                );

                                /*удаляем из реализованного*/
                                unset($realized_schema[$table]['sortings'][$sorting]);

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Удалена сортировка '.$sorting.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }

                    }
                    elseif($change == 'delete_column'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $column_change){

                                /*Вызываем удаления Структуры колонки*/
                                Data_Base::call_delete_structure_column(
                                    $table,
                                    $column
                                );

                                /*удаляем из реализованного*/
                                unset($realized_schema[$table]['columns'][$column]);

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Удалена колонка '.$column.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }

                    }
                    elseif($change == 'delete_table'){

                        foreach($changes[$change] as $table => $table_change){

                            /*Вызываем удаления Структуры таблицы*/
                            Data_Base::call_delete_structure_table(
                                $table
                            );

                            /*удаляем из реализованного*/
                            unset($realized_schema[$table]);

                            /*сохраняем схему реализованного*/
                            self::save_realized_schema_data_base([
                                'Реализованная схема' => $realized_schema,
                            ]);

                            /* Фиксируем реконструкцию базы данных */
                            Realization::fix_reassembly_data_base([
                                'Информация' => 'Удалена таблица '.$table,
                                'Завершение' => false,
                            ]);

                        }

                    }
                    elseif($change == 'correct_comment_table'){
                        Conditions::fix_claim([
                            'Претензия'          => 'correct_comment_table не реализовано' . $instruction_when_error,
                            'Файл'                  => __FILE__,
                            'Номер строчки в файле' => __LINE__,
                            'Заглушка страницы'     => 'error',
                        ]);
                    }
                    elseif($change == 'correct_primary_column_table'){
                        Conditions::fix_claim([
                            'Претензия'          => 'correct_primary_column_table не реализовано' . $instruction_when_error,
                            'Файл'                  => __FILE__,
                            'Номер строчки в файле' => __LINE__,
                            'Заглушка страницы'     => 'error',
                        ]);
                    }
                    elseif($change == 'correct_column'){

                        foreach($changes[$change] as $table => $table_change){
                            foreach($table_change as $column => $column_change){

                                /*Вызываем изменение Структуры колонки*/
                                Data_Base::call_correct_structure_column(
                                    $table,
                                    $column,
                                    $column_change['type'],
                                    $column_change['default'],
                                    $column_change['description']
                                );

                                /*заполняем реализованное*/
                                $realized_schema[$table]['columns'][$column] = [
                                    'type'    => $column_change['type'],
                                    'default' => $column_change['default'],
                                    'description' => $column_change['description'],
                                ];

                                /*сохраняем схему реализованного*/
                                self::save_realized_schema_data_base([
                                    'Реализованная схема' => $realized_schema,
                                ]);

                                /* Фиксируем реконструкцию базы данных */
                                Realization::fix_reassembly_data_base([
                                    'Информация' => 'Изменена колонка '.$column.' в таблице '.$table,
                                    'Завершение' => false,
                                ]);

                            }
                        }
                    }
                    else{
                        Conditions::fix_claim([
                            'Претензия'          => 'no '.$change . $instruction_when_error,
                            'Файл'                  => __FILE__,
                            'Номер строчки в файле' => __LINE__,
                            'Заглушка страницы'     => 'error',
                        ]);
                    }
                }

            }

            return true;

        }catch (\Exception $e) {
            /*фиксируем ошибку*/
            Conditions::fix_claim([
                'Претензия'          => $e->getMessage() . $instruction_when_error,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => 'error',
            ]);
        }

    }
}

?>