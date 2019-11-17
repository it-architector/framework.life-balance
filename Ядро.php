<?php

/*
 * Ядро Framework life balance
 *
 * Исходник: https://github.com/it-architector/framework.life-balance
 *
 *
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

/* Запускаем процесс ядра */
Realization::initiation([]);


?>