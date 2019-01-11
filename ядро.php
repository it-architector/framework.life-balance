<?php

/*
 * ЯДРО.
 *
 * Этапы:
 * 1. Подключение.
 * 2. Инициация.
 * 4. Процесс.
 */

/*
 * 1 этап:
 * Подключение.
 */

/*Подключаем схему внутренних путей*/
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'компоненты-ядра'. DIRECTORY_SEPARATOR . '3_ресурсы'. DIRECTORY_SEPARATOR . 'схемы'. DIRECTORY_SEPARATOR . 'схема_внутренних_путей.php';

/*Подключаем структуру класса решений*/
require_once DIR_STRUCTURE_ESSENCES . 'суть_решений.php';

/*Подключаем структуру класса уведомлений*/
require_once DIR_STRUCTURE_ESSENCES . 'суть_уведомлений.php';

/*Подключаем структуру класса ресурсов*/
require_once DIR_STRUCTURE_ESSENCES . 'суть_ресурсов.php';

/*Подключаем структуру класса дел*/
require_once DIR_STRUCTURE_ESSENCES . 'суть_дел.php';

/*Подключаем класс решений*/
require_once DIR_SOLUTIONS . 'суть_решений.php';

/*Подключаем класс уведомлений*/
require_once DIR_NOTICES . 'суть_уведомлений.php';

/*Подключаем класс ресурсов*/
require_once DIR_RESOURCES . 'суть_ресурсов.php';

/*Подключаем класс дел*/
require_once DIR_BUSINESS . 'суть_дел.php';

/*
 * 2 этап:
 * Инициация.
 */

use \Framework_life_balance\core_components\Notices;
use \Framework_life_balance\core_components\Solutions;
use \Framework_life_balance\core_components\Resources;
use \Framework_life_balance\core_components\Business;

/*Включаем контроль ядра*/
Solutions::initiation();

/*Определяем вывод информации*/
Notices::initiation();

/*Подготавливаем работу с ресурсами*/
Resources::initiation();

/*Подготавливаем работу с наработками*/
Business::initiation();

/*
 * 3 этап:
 * Процесс.
 */

/*Разбираем запрос*/
Solutions::parse_request();

/*Разбираем авторизованность*/
Solutions::parse_authorized();

/*Проверяем запрос на правомерность*/
Solutions::check_request_legality();

/*Создаем комуникацию с памятью*/
Resources::create_communication_with_memory();

/*Проверяем изменения в схеме базы данных*/
Solutions::check_changes_schema_data_base();

/*Создаем комуникацию с базой данных*/
Resources::create_communication_with_data_base();

/*Проверяем запрос на доступность*/
Solutions::check_request_access();

/*Разбираем параметры запроса*/
Solutions::parse_parameters_request();

/*Проверяем запрос на деструктив*/
Solutions::check_request_destructive();

/*Выполняем запрошенную наработанную цель*/
Business::execute_request_experience_goal();

/*Проверяем ответ на правильность*/
Solutions::check_answer_correct();

/*Результат выполнения в интерфейс*/
Notices::result_executed_to_interface();

/*Прекращаем работу ядра*/
Solutions::stop_core();

?>