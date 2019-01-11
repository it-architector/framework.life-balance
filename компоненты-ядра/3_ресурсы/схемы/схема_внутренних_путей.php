<?php

/* Схема внутренних путей */

/*корень*/
define('DIR_ROOT', dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR);


/*компоненты ядра*/
define('DIR_CORE_COMPONENTS', DIR_ROOT . 'компоненты-ядра' . DIRECTORY_SEPARATOR);

/*пользовательские данные*/
define('DIR_USERS_DATA', DIR_ROOT . 'пользовательские-данные' . DIRECTORY_SEPARATOR);

/*компоненты интерфейса*/
define('DIR_INTERFACE_COMPONENTS', DIR_ROOT . 'компоненты-интерфейса' . DIRECTORY_SEPARATOR);


/*решения*/
define('DIR_SOLUTIONS', DIR_CORE_COMPONENTS . '1_решения' . DIRECTORY_SEPARATOR);

/*уведомления*/
define('DIR_NOTICES', DIR_CORE_COMPONENTS . '2_уведомления' . DIRECTORY_SEPARATOR);

/*ресурсы*/
define('DIR_RESOURCES', DIR_CORE_COMPONENTS . '3_ресурсы' . DIRECTORY_SEPARATOR);

/*дела*/
define('DIR_BUSINESS', DIR_CORE_COMPONENTS . '4_дела' . DIRECTORY_SEPARATOR);


/*модули*/
define('DIR_MODULES', DIR_SOLUTIONS . 'модули' . DIRECTORY_SEPARATOR);

/*github.com модули*/
define('DIR_GITHUB_MODULES', DIR_MODULES . 'github.com' . DIRECTORY_SEPARATOR);

/*свои модули*/
define('DIR_THEIR_MODULES', DIR_MODULES . 'свои' . DIRECTORY_SEPARATOR);

/*структуры*/
define('DIR_STRUCTURES', DIR_NOTICES . 'структуры' . DIRECTORY_SEPARATOR);

/*структуры своих модулей*/
define('DIR_STRUCTURE_THEIR_MODULES', DIR_STRUCTURES . 'свои_модули' . DIRECTORY_SEPARATOR);

/*структуры сутей*/
define('DIR_STRUCTURE_ESSENCES', DIR_STRUCTURES . 'сути' . DIRECTORY_SEPARATOR);

/*структуры наработок*/
define('DIR_STRUCTURE_EXPERIENCES', DIR_STRUCTURES . 'наработки' . DIRECTORY_SEPARATOR);

/*конфигурация схем*/
define('DIR_SCHEMES', DIR_RESOURCES . 'схемы' . DIRECTORY_SEPARATOR);

/*наработки*/
define('DIR_EXPERIENCES', DIR_BUSINESS . 'наработки' . DIRECTORY_SEPARATOR);

/*протоколы*/
define('DIR_PROTOCOLS', DIR_BUSINESS . 'протоколы' . DIRECTORY_SEPARATOR);


/*картинки пользователей*/
define('DIR_USERS_IMAGES', DIR_USERS_DATA . 'images' . DIRECTORY_SEPARATOR);

/*html шаблоны*/
define('DIR_HTML', DIR_INTERFACE_COMPONENTS . '4_формы' . DIRECTORY_SEPARATOR . 'шаблоны' . DIRECTORY_SEPARATOR);


?>
