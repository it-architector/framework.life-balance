/**************МОДУЛИ**************/

/* Модуль J query */
include_module('J query', 'jquery.min', 'js');
include_module('J query', 'jquery.nicescroll.min', 'js');
include_module('J query', 'jquery.validate', 'js');
include_module('J query', 'jquery.cookie', 'js');
include_module('J query', 'jquery.BlackAndWhite', 'js');
include_module('J query', 'jquery.flexslider-min', 'js');
include_module('J query', 'flexslider/flexslider', 'css');
include_module('J query', 'animate/animate', 'js');
include_module('J query', 'animate/animate', 'css');
include_module('J query', 'superfish.min', 'js');
include_module('J query', 'owl.carousel/owl.carousel', 'js');
include_module('J query', 'owl.carousel/owl.carousel', 'css');

/* Модуль Boot strap */
include_module('Boot strap', 'bootstrap.min', 'js');
include_module('Boot strap', 'bootstrap.min', 'css');

/* Модуль Font awesome */
include_module('Font awesome', 'font-awesome 4.0.3', 'css');

/* Модуль Files tree */
include_module('Files tree', 'jqueryFileTree', 'css');

/**************ФУНКЦИИ**************/

/* Функция подключения модуля */
function include_module(module_name, file_name, file_type){

    if(file_type === 'js'){

        document.write('<script src="/Компоненты%20интерфейса/5.Модули/' + module_name + '/' + file_name + '.js" type="text/javascript"></script>');

    }
    else if(file_type === 'css'){

        document.write('<link href="/Компоненты%20интерфейса/5.Модули/' + module_name + '/' + file_name + '.css" rel="stylesheet" type="text/css" />');

    }


}
