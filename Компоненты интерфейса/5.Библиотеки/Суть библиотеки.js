/* Подключаем файлы js */
include_js('/jquery/jquery.min.js');
include_js('/jquery/jquery.prettyPhoto.js');
include_js('/jquery/jquery.nicescroll.min.js');
include_js('/jquery/jquery.validate.js');
include_js('/jquery/jquery.cookie.js');
include_js('/jquery/jquery.flexslider-min.js');
include_js('/jquery/jquery.BlackAndWhite.js');
include_js('/bootstrap/bootstrap.min.js');
include_js('/superfish/superfish.min.js');
include_js('/owl.carousel/owl.carousel.js');
include_js('/animate/animate.js');

/* Подключаем файлы css */
include_css('/animate/animate.css');
include_css('/bootstrap/bootstrap.min.css');
include_css('/flexslider/flexslider.css');
include_css('/jquery/jqueryFileTree.css');
include_css('/owl.carousel/owl.carousel.css');
include_css('/prettyPhoto/prettyPhoto.css');

/* Функция Подключения файла js */
function include_js(file){
    document.write('<script src="/Компоненты%20интерфейса/5.Библиотеки' + file + '" type="text/javascript"></script>');

}

/* Функция Подключения файла css */
function include_css(file){
    document.write('<link href="/Компоненты%20интерфейса/5.Библиотеки' + file + '" rel="stylesheet" type="text/css" />');

}
