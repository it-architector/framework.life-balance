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
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Компоненты ядра' . DIRECTORY_SEPARATOR . '2.Пространство' . DIRECTORY_SEPARATOR . 'Структуры' . DIRECTORY_SEPARATOR . '1.Структура внутренних путей.php';

/* Подключаем функции компонента орентировка */
require_once DIR_FUNCTIONS_ESSENCES . '1.Функции компонента условия.php';

/* Подключаем функции компонента условия */
require_once DIR_FUNCTIONS_ESSENCES . '2.Функции компонента пространство.php';

/* Подключаем функции компонента распределение */
require_once DIR_FUNCTIONS_ESSENCES . '3.Функции компонента распределение.php';

/* Подключаем функции компонента интеллект */
require_once DIR_FUNCTIONS_ESSENCES . '4.Функции компонента реализация.php';

/* Подключаем функции категории сайта index */
require_once DIR_FUNCTIONS_SITE . 'Функции категорий сайта index.php';

/* Подключаем функции категории сайта control */
require_once DIR_FUNCTIONS_SITE . 'Функции категорий сайта control.php';

/* Подключаем функции категории сайта users */
require_once DIR_FUNCTIONS_SITE . 'Функции категорий сайта users.php';

/* Подключаем настройку подключения модулей */
require_once DIR_MODULES . 'Настройка подключения модулей.php';

/*
 * 2 этап:
 * Инициация.
 */

use \Framework_life_balance\core_components\Space;
use \Framework_life_balance\core_components\Conditions;
use \Framework_life_balance\core_components\Distribution;
use \Framework_life_balance\core_components\Realization;

/* Включаем контроль ядра */
Conditions::initiation([]);

/* Определяем вывод информации */
Space::initiation([]);

/* Подготавливаем работу с ресурсами */
Distribution::initiation([]);

/* Подготавливаем работу движений */
Realization::initiation([]);

/*
 * 3 этап:
 * Процесс.
 */

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

?>