/**************МОДУЛИ**************/

/* Модуль J query */
include_module({
    'module_name' : 'J query',
    'module_files': [
        {
            'file_name': 'jquery.min',
            'file_type': 'js',
        },
        {
            'file_name': 'jquery.nicescroll.min',
            'file_type': 'js',
        },
        {
            'file_name': 'jquery.validate',
            'file_type': 'js',
        },
        {
            'file_name': 'jquery.cookie',
            'file_type': 'js',
        },
        {
            'file_name': 'jquery.BlackAndWhite',
            'file_type': 'js',
        },
        {
            'file_name': 'jquery.flexslider-min',
            'file_type': 'js',
        },
        {
            'file_name': 'superfish.min',
            'file_type': 'js',
        },
    ]
});

/* Модуль J query/Flex slider */
include_module({
    'module_name' : 'J query/Flex slider',
    'module_files': [
        {
            'file_name': 'jQuery FlexSlider v2.2.0',
            'file_type': 'css',
        },
    ]
});

/* Модуль J query/Animate */
include_module({
    'module_name' : 'J query/Animate',
    'module_files': [
        {
            'file_name': 'Animate 0.3.3',
            'file_type': 'js',
        },
        {
            'file_name': 'Animate 0.3.3',
            'file_type': 'css',
        },
    ]
});

/* Модуль J query/Owl carousel */
include_module({
    'module_name' : 'J query/Owl carousel',
    'module_files': [
        {
            'file_name': 'jQuery OwlCarousel v1.3.2',
            'file_type': 'js',
        },
        {
            'file_name': 'Core Owl Carousel CSS File v1.3.2',
            'file_type': 'css',
        },
    ]
});

/* Модуль Boot strap */
include_module({
    'module_name' : 'Boot strap',
    'module_files': [
        {
            'file_name': 'Bootstrap.js v3.0.0 by @fat and @mdo',
            'file_type': 'js',
        },
        {
            'file_name': 'Bootstrap v3.0.0',
            'file_type': 'css',
        },
    ]
});

/* Модуль Font awesome */

include_module({
    'module_name' : 'Font awesome',
    'module_files': [
        {
            'file_name': 'font-awesome 4.0.3',
            'file_type': 'css',
        },
    ]
});

/* Модуль Files tree */

include_module({
    'module_name' : 'Files tree',
    'module_files': [
        {
            'file_name': 'jqueryFileTree',
            'file_type': 'css',
        },
    ]
});

/**************ФУНКЦИИ**************/

/* Функция подключения модуля */
function include_module($parameters = {
    'module_name' : null,
    'module_files': [
        {
            'file_name': null,
            'file_type': null,
        },
        {
            'file_name': null,
            'file_type': null,
        },
    ],
}){

    $parameters['module_files'].forEach(function($module_file) {

        if($module_file['file_type'] === 'js'){

            document.write('<script src="/Компоненты%20интерфейса/5.Модули/' + $parameters['module_name'] + '/' + $module_file['file_name'] + '.js" type="text/javascript"></script>');

        }
        else if($module_file['file_type'] === 'css'){

            document.write('<link href="/Компоненты%20интерфейса/5.Модули/' + $parameters['module_name'] + '/' + $module_file['file_name'] + '.css" rel="stylesheet" type="text/css" />');

        }

    });

}
