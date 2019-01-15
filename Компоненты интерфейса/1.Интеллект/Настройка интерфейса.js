document.addEventListener('DOMContentLoaded', function(){

    /* Инициируем взаимодействие с ядром */

    /*метод проверки русских букв*/
    $.validator.addMethod('russian_letters', function (value) {
        return /[\Wа-яА-ЯёЁ]/.test(value);
    }, '');

    /* переводим навигационные ссылки на core режим */
    framework_life_balance_transferLinkToCore('.menu_block a');

    /* переводим формы на core режим */
    framework_life_balance_transferFormToCore('container_navigation');
    framework_life_balance_transferFormToCore('container_contacts');

    /*отмечаем что вначале запрос был пустым*/
    framework_life_balance_saveCoreUrl('-');

    /* загружаем текущую страницу посредством core */
    framework_life_balance_loadDataFromCore(window.location.pathname + window.location.search + window.location.hash,'');

    /* показываем авторизацию */
    framework_life_balance_showAuth();

    //var fixed_menu = true;
    //window.jQuery = window.$ = jQuery;

//BlackAndWhite
    $(window).load(function(){
        $('.client_img').BlackAndWhite({
            hoverEffect : true, // default true
            // set the path to BnWWorker.js for a superfast implementation
            webworkerPath : false,
            // for the images with a fluid width and height
            responsive:true,
            // to invert the hover effect
            invertHoverEffect: false,
            // this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
            intensity:1,
            speed: { //this property could also be just speed: value for both fadeIn and fadeOut
                fadeIn: 300, // 200ms for fadeIn animations
                fadeOut: 300 // 800ms for fadeOut animations
            },
            onImageReady:function(img) {
                // this callback gets executed anytime an image is converted
            }
        });


    });
    jQuery(document).ready(function() {
        jQuery("body").niceScroll({
            cursorcolor:"#333",
            cursorborder:"0px",
            cursorwidth :"8px",
            zindex:"9999"
        });

        //Preloader
        setTimeout("jQuery('.preloader_hide, .selector_open').animate({'opacity' : '1'},500)",800);
        setTimeout("jQuery('footer').animate({'opacity' : '1'},500)",2000);
    });


    /*-----------------------------------------------------------------------------------*/
    /*	MENU
    /*-----------------------------------------------------------------------------------*/


    jQuery(document).ready(function() {
        //MobileMenu
        if ($(window).width() < 768){
            jQuery('.menu_block .container').prepend('<a href="" class="menu_toggler"><span class="fa fa-align-justify"></span></a>');
            jQuery('header .navmenu').hide();
            jQuery('.menu_toggler, .navmenu ul li a').click(function(){
                jQuery('header .navmenu').slideToggle(300);
            });
        }
        $(window).scroll(function(event) {
            //calculateScroll();
        });
    });


    /* Superfish */
    jQuery(document).ready(function() {
        if ($(window).width() >= 768){
            $('.navmenu ul').superfish();
        }
    });

    /*-----------------------------------------------------------------------------------*/
    /*	FLEXSLIDER
    /*-----------------------------------------------------------------------------------*/

    function homeHeight(){
        var wh = jQuery(window).height() - 80;
        jQuery('.top_slider, .top_slider .slides li').css('height', wh);
    }

    /*-----------------------------------------------------------------------------------*/
    /*	FOOTER HEIGHT
    /*-----------------------------------------------------------------------------------*/
    jQuery(document).ready(function() {
        contactHeight();
    });

    jQuery(window).resize(function(){
        contactHeight();
    });

    function contactHeight(){
        if ($(window).width() > 991){
            var wh = jQuery('footer').height() + 70;
            jQuery('#contacts').css('min-height', wh);
        }


    }

});

