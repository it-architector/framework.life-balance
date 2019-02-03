/**************МОДУЛИ**************/

/* Модуль jQuery */
include_js('/jquery/jquery.min.js');
include_js('/jquery/jquery.nicescroll.min.js');
include_js('/jquery/jquery.validate.js');
include_js('/jquery/jquery.cookie.js');
include_js('/jquery/jquery.flexslider-min.js');
include_js('/jquery/jquery.BlackAndWhite.js');

/* Модуль animate */
include_js('/animate/animate.js');
include_css('/animate/animate.css');

/* Модуль bootstrap */
include_js('/bootstrap/bootstrap.min.js');
include_css('/bootstrap/bootstrap.min.css');

/* Модуль owl.carousel */
include_js('/owl.carousel/owl.carousel.js');
include_css('/owl.carousel/owl.carousel.css');

/* Модуль font-awesome */
include_css('/font-awesome/font-awesome 4.0.3.css');

/* Модуль superfish */
include_js('/superfish/superfish.min.js');

/* Модуль flexslider */
include_css('/flexslider/flexslider.css');

/* Модуль filestree */
include_css('/filestree/jqueryFileTree.css');

/**************ФУНКЦИИ**************/

/* Функция Подключения файла js */
function include_js(file){
    document.write('<script src="/Компоненты%20интерфейса/5.Модули' + file + '" type="text/javascript"></script>');

}

/* Функция Подключения файла css */
function include_css(file){
    document.write('<link href="/Компоненты%20интерфейса/5.Модули' + file + '" rel="stylesheet" type="text/css" />');

}
