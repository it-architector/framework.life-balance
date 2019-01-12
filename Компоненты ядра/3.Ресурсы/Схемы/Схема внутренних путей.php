<?php

/* Схема внутренних путей */

/*корень*/
define('DIR_ROOT', dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR);


/*компоненты ядра*/
define('DIR_CORE_COMPONENTS', DIR_ROOT . 'Компоненты ядра' . DIRECTORY_SEPARATOR);

/*пользовательские данные*/
define('DIR_USERS_DATA', DIR_ROOT . 'Пользовательские данные' . DIRECTORY_SEPARATOR);

/*компоненты интерфейса*/
define('DIR_INTERFACE_COMPONENTS', DIR_ROOT . 'Компоненты интерфейса' . DIRECTORY_SEPARATOR);


/*решения*/
define('DIR_SOLUTIONS', DIR_CORE_COMPONENTS . '1.Решения' . DIRECTORY_SEPARATOR);

/*уведомления*/
define('DIR_NOTICES', DIR_CORE_COMPONENTS . '2.Уведомления' . DIRECTORY_SEPARATOR);

/*ресурсы*/
define('DIR_RESOURCES', DIR_CORE_COMPONENTS . '3.Ресурсы' . DIRECTORY_SEPARATOR);

/*дела*/
define('DIR_BUSINESS', DIR_CORE_COMPONENTS . '4.Дела' . DIRECTORY_SEPARATOR);


/*Модули*/
define('DIR_MODULES', DIR_SOLUTIONS . 'Модули' . DIRECTORY_SEPARATOR);

/*Github.com Модули*/
define('DIR_GITHUB_MODULES', DIR_MODULES . 'Github.com' . DIRECTORY_SEPARATOR);

/*Свои модули*/
define('DIR_THEIR_MODULES', DIR_MODULES . 'Свои' . DIRECTORY_SEPARATOR);

/*Структуры*/
define('DIR_STRUCTURES', DIR_NOTICES . 'Структуры' . DIRECTORY_SEPARATOR);

/*Структуры модулей*/
define('DIR_STRUCTURE_THEIR_MODULES', DIR_STRUCTURES . 'Модули' . DIRECTORY_SEPARATOR);

/*Структуры сутей*/
define('DIR_STRUCTURE_ESSENCES', DIR_STRUCTURES . 'Сути' . DIRECTORY_SEPARATOR);

/*Структуры наработок*/
define('DIR_STRUCTURE_EXPERIENCES', DIR_STRUCTURES . 'Наработки' . DIRECTORY_SEPARATOR);

/*конфигурация схем*/
define('DIR_SCHEMES', DIR_RESOURCES . 'Схемы' . DIRECTORY_SEPARATOR);

/*Наработки*/
define('DIR_EXPERIENCES', DIR_BUSINESS . 'Наработки' . DIRECTORY_SEPARATOR);

/*Протоколы*/
define('DIR_PROTOCOLS', DIR_BUSINESS . 'Протоколы' . DIRECTORY_SEPARATOR);

/* Изменения */
define('DIR_CHANGES', DIR_PROTOCOLS . 'Изменения' . DIRECTORY_SEPARATOR);


/*Картинки пользователей*/
define('DIR_USERS_IMAGES', DIR_USERS_DATA . 'images' . DIRECTORY_SEPARATOR);

/*html блоки*/
define('DIR_HTML', DIR_INTERFACE_COMPONENTS . '4.Формы' . DIRECTORY_SEPARATOR . 'Блоки' . DIRECTORY_SEPARATOR);


?>
