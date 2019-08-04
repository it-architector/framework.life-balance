<?php 

/* Корень */
define('DIR_ROOT', dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR);



/* Компоненты ядра */
define('DIR_CORE_COMPONENTS', DIR_ROOT . 'Компоненты ядра' . DIRECTORY_SEPARATOR);

/* Компоненты интерфейса */
define('DIR_INTERFACE_COMPONENTS', DIR_ROOT . 'Компоненты интерфейса' . DIRECTORY_SEPARATOR);

/* Пользовательские данные */
define('DIR_USERS_DATA', DIR_ROOT . 'Пользовательские данные' . DIRECTORY_SEPARATOR);



/* Компонент условия */
define('DIR_CONDITIONS', DIR_CORE_COMPONENTS . '1.Условия' . DIRECTORY_SEPARATOR);

/* Компонент пространство */
define('DIR_SPACE', DIR_CORE_COMPONENTS . '2.Пространство' . DIRECTORY_SEPARATOR);

/* Компонент распределения */
define('DIR_DISTRIBUTION', DIR_CORE_COMPONENTS . '3.Распределение' . DIRECTORY_SEPARATOR);

/* Компонент реализация */
define('DIR_REALIZATION', DIR_CORE_COMPONENTS . '4.Реализация' . DIRECTORY_SEPARATOR);

/* Компонент модули */
define('DIR_MODULES', DIR_CORE_COMPONENTS . '5.Модули' . DIRECTORY_SEPARATOR);



/* Протоколы процессов компонента условия*/
define('DIR_PROTOCOLS_PROCESSES', DIR_CONDITIONS . '2.Сведения' . DIRECTORY_SEPARATOR . 'Сведения о процессах' . DIRECTORY_SEPARATOR);

/* Модули с github.com */
define('DIR_GITHUB_MODULES', DIR_MODULES . 'Модули с github.com' . DIRECTORY_SEPARATOR);

/* Модуль для базы данных mysql */
define('DIR_MODULE_DATA_BASE', DIR_MODULES . 'Модуль для базы данных mysql' . DIRECTORY_SEPARATOR);

/* Структуры компонента пространство */
define('DIR_STRUCTURES', DIR_SPACE . 'Структуры' . DIRECTORY_SEPARATOR);

/* Элементы компонента распределение */
define('DIR_ITEMS', DIR_DISTRIBUTION . 'Элементы' . DIRECTORY_SEPARATOR);

/* Функции компонента реализация */
define('DIR_FUNCTIONS', DIR_REALIZATION . 'Функции' . DIRECTORY_SEPARATOR);

/* Функции категорий сайта компонента реализация */
define('DIR_FUNCTIONS_SITE', DIR_FUNCTIONS . 'Функции категорий сайта' . DIRECTORY_SEPARATOR);

/* Функции компонентов компонента реализация */
define('DIR_FUNCTIONS_ESSENCES', DIR_FUNCTIONS . 'Функции компонентов' . DIRECTORY_SEPARATOR);

/* Результаты компонента реализация */
define('DIR_RESULTS', DIR_REALIZATION . 'Результаты' . DIRECTORY_SEPARATOR);



/* Картинки пользователей */
define('DIR_USERS_IMAGES', DIR_USERS_DATA . 'images' . DIRECTORY_SEPARATOR);

/* Html блоки */
define('DIR_HTML', DIR_INTERFACE_COMPONENTS . '3.Распределение' . DIRECTORY_SEPARATOR . 'Элементы' . DIRECTORY_SEPARATOR . 'Элементы тэгов' . DIRECTORY_SEPARATOR);


?>
