<?php

/*
 * Ядро Framework life balance
 *
 * Исходник: https://github.com/veter-love/framework-life-balance-v1
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

/* Подключаем схему внутренних путей */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Компоненты ядра'. DIRECTORY_SEPARATOR . '1.Ориентировка' . DIRECTORY_SEPARATOR . 'Сведения' . DIRECTORY_SEPARATOR . 'Вводные' . DIRECTORY_SEPARATOR . 'Вводное сведение о внутренних путях.php';

/* Подключаем функции компонента орентировка */
require_once DIR_EXPERIENCES_ESSENCES . '1.Функции компонента орентировка.php';

/* Подключаем функции компонента представления */
require_once DIR_EXPERIENCES_ESSENCES . '2.Функции компонента представление.php';

/* Подключаем функции компонента распределение */
require_once DIR_EXPERIENCES_ESSENCES . '3.Функции компонента распределение.php';

/* Подключаем функции компонента интеллект */
require_once DIR_EXPERIENCES_ESSENCES . '4.Функции компонента движение.php';

/* Подключаем функции категории сайта index */
require_once DIR_EXPERIENCES_SITE . 'Функции категории сайта index.php';

/* Подключаем функции категории сайта control */
require_once DIR_EXPERIENCES_SITE . 'Функции категории сайта control.php';

/* Подключаем функции категории сайта users */
require_once DIR_EXPERIENCES_SITE . 'Функции категории сайта users.php';

/* Подключаем настройку подключения модулей */
require_once DIR_MODULES . 'Настройка подключения модулей.php';

/*
 * 2 этап:
 * Инициация.
 */

use \Framework_life_balance\core_components\Representation;
use \Framework_life_balance\core_components\Orientation;
use \Framework_life_balance\core_components\Distribution;
use \Framework_life_balance\core_components\Motion;

/* Включаем контроль ядра */
Orientation::initiation();

/* Определяем вывод информации */
Representation::initiation();

/* Подготавливаем работу с ресурсами */
Distribution::initiation();

/* Подготавливаем работу движений */
Motion::initiation();

/*
 * 3 этап:
 * Процесс.
 */

/* Разбираем запрос */
Orientation::parse_request();

/* Разбираем авторизованность */
Orientation::parse_authorized();

/* Проверяем запрос на правомерность */
Orientation::check_request_legality();

/* Создаем комуникацию с памятью */
Distribution::create_communication_with_memory();

/* Проверяем изменения в схеме базы данных */
Orientation::check_changes_schema_data_base();

/* Создаем комуникацию с базой данных */
Distribution::create_communication_with_data_base();

/* Проверяем запрос на доступность */
Orientation::check_request_access();

/* Разбираем параметры запроса */
Orientation::parse_parameters_request();

/* Проверяем запрос на деструктив */
Orientation::check_request_destructive();

/* Выполняем запрошенную наработанную цель */
Motion::execute_request_experience_goal();

/* Проверяем ответ на правильность */
Orientation::check_answer_correct();

/* Результат выполнения в интерфейс */
Representation::result_executed_to_interface();

/* Прекращаем работу ядра */
Orientation::stop_core();

?>