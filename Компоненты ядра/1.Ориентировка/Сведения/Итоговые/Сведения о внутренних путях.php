<?php

/* Схема внутренних путей */

/* Корень */
define('DIR_ROOT', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR);


/* Компонент ядра */
define('DIR_CORE_COMPONENTS', DIR_ROOT . 'Компоненты ядра' . DIRECTORY_SEPARATOR);

/* Компоненты интерфейса */
define('DIR_INTERFACE_COMPONENTS', DIR_ROOT . 'Компоненты интерфейса' . DIRECTORY_SEPARATOR);

/* Пользовательские данные */
define('DIR_USERS_DATA', DIR_ROOT . 'Пользовательские данные' . DIRECTORY_SEPARATOR);


/* Компонент решения */
define('DIR_SOLUTIONS', DIR_CORE_COMPONENTS . '1.Ориентировка' . DIRECTORY_SEPARATOR);

/* Компонент уведомления */
define('DIR_NOTICES', DIR_CORE_COMPONENTS . '2.Представления' . DIRECTORY_SEPARATOR);

/* Компонент ресурсов */
define('DIR_RESOURCES', DIR_CORE_COMPONENTS . '3.Ресурсы' . DIRECTORY_SEPARATOR);

/* Компонент дела */
define('DIR_BUSINESS', DIR_CORE_COMPONENTS . '4.Интеллект' . DIRECTORY_SEPARATOR);

/* Компонент модулей */
define('DIR_MODULES', DIR_CORE_COMPONENTS . '5.Модули' . DIRECTORY_SEPARATOR);

/* Github.com Модули */
define('DIR_GITHUB_MODULES', DIR_MODULES . 'Github.com' . DIRECTORY_SEPARATOR);

/* Модуль базы данных mysql */
define('DIR_MODULE_DATA_BASE', DIR_MODULES . 'Модуль базы данных mysql' . DIRECTORY_SEPARATOR);

/* Структуры */
define('DIR_STRUCTURES', DIR_NOTICES . 'Структуры' . DIRECTORY_SEPARATOR);

/* Схемы */
define('DIR_SCHEMES', DIR_RESOURCES . 'Схемы' . DIRECTORY_SEPARATOR);

/* Функции */
define('DIR_EXPERIENCES', DIR_BUSINESS . 'Функции' . DIRECTORY_SEPARATOR);

/* Функции сайта */
define('DIR_EXPERIENCES_SITE', DIR_EXPERIENCES . 'Категории сайта' . DIRECTORY_SEPARATOR);

/* Функции компонентов */
define('DIR_EXPERIENCES_ESSENCES', DIR_EXPERIENCES . 'Компоненты' . DIRECTORY_SEPARATOR);

/* Протоколы */
define('DIR_PROTOCOLS', DIR_BUSINESS . 'Протоколы' . DIRECTORY_SEPARATOR);

/* Изменения */
define('DIR_CHANGES', DIR_PROTOCOLS . 'Изменения' . DIRECTORY_SEPARATOR);


/* Картинки пользователей */
define('DIR_USERS_IMAGES', DIR_USERS_DATA . 'images' . DIRECTORY_SEPARATOR);

/* Html блоки */
define('DIR_HTML', DIR_INTERFACE_COMPONENTS . '4.Формы' . DIRECTORY_SEPARATOR . 'Блоки' . DIRECTORY_SEPARATOR);


?>
