class Intelligence {

    static initiation() {

        /*метод проверки русских букв*/
        jQuery.validator.addMethod('russian_letters', function (value) {
            return /[\Wа-яА-ЯёЁ]/.test(value);
        }, '');

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
        /*	FOOTER HEIGHT
        /*-----------------------------------------------------------------------------------*/
        jQuery(document).ready(function() {
            Intelligence.height_scroll_bar();
        });

        jQuery(window).resize(function(){
            Intelligence.height_scroll_bar();
        });

        /* Yandex.Metrika counter */
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter51370444 = new Ya.Metrika2({
                        id:51370444,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/tag.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks2");

        /* Форма для ошибок*/

        document.getElementById("input_message_error").onblur = function() {
            if (this.value === ''){
                this.value = 'Сообщение об ошибке';
            }
        };

        document.getElementById("input_message_error").onfocus = function() {
            if (this.value === 'Сообщение об ошибке'){
                this.value = '';
                jQuery('#contact-form-face input[name=nickname_guest]').show();
                jQuery('#contact-form-face input[name=email_guest]').show();
            }
        };

        document.getElementById("input_nickname_guest").onblur = function() {
            if (this.value === ''){
                this.value = 'Псевдоним';
            }
        };

        document.getElementById("input_nickname_guest").onfocus = function() {
            if (this.value === 'Псевдоним'){
                this.value = '';
            }
        };

        document.getElementById("input_email_guest").onblur = function() {
            if (this.value === ''){
                this.value = 'Ваш email';
            }
        };

        document.getElementById("input_email_guest").onfocus = function() {
            if (this.value === 'Ваш email'){
                this.value = '';
            }
        };



    }

    /* Формирует высоту сколлинга */
    static height_scroll_bar(){
        if ($(window).width() > 991){
            var wh = jQuery('footer').height() + 70;
            jQuery('#contacts').css('min-height', wh);
        }

    }

    /*запоминаем запрос*/
    static save_called_core_url(url) {
        if(url!==''){
            this.called_core_url = url;
        }
    }

    /*получаем последний запрос*/
    static get_called_core_url() {
        return this.called_core_url;
    }

    /* Получаем категорию сайта по ответу */
    static get_category_by_page_link(link) {

        var link_explode = link.split('#',2);

        link = link_explode[0];

        link_explode = link.split('/',3);

        return link_explode[1];

    }

    /* Получаем выполненную цель по ответу */
    static get_goal_by_page_link(link) {

        var link_explode = link.split('#',2);

        link = link_explode[0];

        link_explode = link.split('/',3);

        return link_explode[2];

    }

    /* формируем ссылки для передачи запроса в ядро */
    static formation_core_url(link) {

        var core_url = '';
        var link_explode = link.split('#',2);

        /*отмечаем что есть запрос к ядру*/
        if(link_explode[0]!==''){
            core_url = "/Ядро.php?request=" + link_explode[0].replace("?", "&");
        }

        /*отмечаем переход на якорь*/
        if(typeof(link_explode[1]) != "undefined"){
            window.location.hash = link_explode[1];
        }
        else{
            window.location.hash = "";
        }

        return core_url;
    }

    /*переходит на якорь*/
    static navigation_to_page_anchor() {
        if(window.location.hash!==""){
            if(jQuery(window.location.hash).offset() !== undefined){
                var scrollTop = jQuery(window.location.hash).offset().top - 80;
                jQuery('html, body').animate({scrollTop: scrollTop}, 1000);
            }
        }
    }

    /* показываем авторизацию */
    static show_authorization_panel() {

        jQuery.post('/Ядро.php?request=/users/authorized_data','').done(function(values){

            if(values!=false && typeof(values['content']['user_data']['nickname']) != "undefined"){
                jQuery('#authed-url').html('<i class="fa fa-user"></i> ' + values['content']['user_data']['nickname']);
                jQuery('#auth-menu').fadeOut('slow');
                setTimeout(function() {
                    jQuery('#authed-menu').fadeIn('slow');
                },1000);

                if(values['content']['user_data']['is_admin']=='true'){
                    jQuery('#control-menu').fadeIn('slow');
                }
                else{
                    jQuery('#control-menu').fadeOut('slow');
                }

            }
            else{
                jQuery('#authed-menu').fadeOut('slow');
                setTimeout(function() {
                    jQuery('#auth-menu').fadeIn('slow');
                },1000);
                jQuery('#control-menu').fadeOut('slow');
            }
        }).fail(function(xhr, status, error) {
            jQuery('#authed-menu').fadeOut('slow');
            setTimeout(function() {
                jQuery('#auth-menu').fadeIn('slow');
            },1000);
            jQuery('#control-menu').fadeOut('slow');
        });

    }

    /* показываем анимацию загрузки данных */
    static show_loader() {

        jQuery('#content').slideToggle('slow');
        jQuery('#preloader').show();

    }

    /* показываем загруженные данные */
    static show_content(category, goal, response) {

        /*устанавливаем заголовок*/
        if(typeof(response["title"]) != "undefined"){
            jQuery('title').text(response["title"]);
        }

        /*устанавливаем короткое описание*/
        if(typeof(response["description"]) != "undefined"){
            jQuery('meta[name=description]').attr('content', response["description"]);
        }

        /*устанавливаем ключевые слова*/
        if(typeof(response["keywords"]) != "undefined"){
            jQuery('meta[name=keywords]').attr('content', response["keywords"]);
        }

        var content_body = '';

        if(typeof(response["content"]) == "undefined"){

            content_body = response;

        }
        /*обёртываем в html*/
        else if(typeof(list_blocks['/' + category + '/' + goal]) != "undefined"){

            content_body = this.packaging_core_data(category, goal);

        }

        setTimeout(function() {

            jQuery('#preloader').hide();
            jQuery('#content').html(content_body).slideDown('slow');

            /* Выполняем функцию страницы */
            if(typeof(window["Category_" + category]) != "undefined" && typeof(window["Category_" + category][goal]) != "undefined"){
                window["Category_" + category][goal](response["content"]);
            }

            /* переводим ссылки на core режим */
            Intelligence.communication_link_with_core('#content a.to_core');

            /* переводим формы на core режим */
            Intelligence.communication_form_with_core('content');

            /*переходим на якорь*/
            setTimeout(function(){
                Intelligence.navigation_to_page_anchor();
            },800);

        }, 800);

    }

    /* показываем ошибку работы ajax */
    static show_error(error) {
        jQuery('#preloader').hide();
        jQuery('#content').html('<div style="padding: 30px;">' + error + '</div>').slideDown('slow');
    }

    /* Загружаем страницу */
    static load_page(page_link, post_data) {

        var category = this.get_category_by_page_link(page_link)
        var goal = this.get_goal_by_page_link(page_link);

        var core_last_url = this.get_called_core_url();
        var core_url = this.formation_core_url(page_link);

        this.save_called_core_url(core_url);

        /*отправляем данные в ядро по post*/
        if(core_url !== '' && (core_last_url !== core_url || (core_last_url === core_url && window.location.hash === ""))){

            /* показываем анимацию загрузки данных */
            this.show_loader();

            this.load_core_data(category, goal, core_url, post_data);

        }
        else{
            /*переходит на якорь*/
            this.navigation_to_page_anchor();
        }

    }

    /* Загружаем данные с ядра */
    static load_core_data(category, goal, core_url, post_data) {

        var request = new XMLHttpRequest();

        request.open('POST', core_url, false);

        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send(post_data);

        if (request.status === 200) {

            var response_text = request.responseText;

            /* Ответ в Json формате */
            try {

                var response = JSON.parse(response_text);

                if(typeof(response["category"]) == "undefined"){
                    Intelligence.show_error(response);
                }

                category = response["category"];
                goal = response["goal"];

                Intelligence.show_content(category, goal, response);


            }
            /* Ответ текстом */
            catch (e){
                Intelligence.show_content(category, goal, response_text);
            }

        }
        else {
            Intelligence.show_error(request.status + ': ' + request.statusText);
        }

    }

    /* Оборачиваем данные с ядра */
    static packaging_core_data(category, goal){

        /*ссылка на шаблон html*/
        var html_file_url = '/Компоненты интерфейса/3.Аккумуляция/Формы/Блоки/Блоки категории сайта ' + category + '/' + goal + '.html';

        var request = new XMLHttpRequest();

        request.open('GET', html_file_url, false);

        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send();

        if (request.status === 200) {

            return request.responseText;

        }
        else {
            return false;
        }

    }

    /* переводим ссылки на core режим */
    static communication_link_with_core(anchor) {

        jQuery(anchor).click(function(){

            var page_link = jQuery(this).attr('href');

            history.pushState(null, null, page_link);

            Intelligence.load_page(page_link,'');

            return false;

        });
    }

    /* переводим формы на core режим */
    static communication_form_with_core(anchor) {

        jQuery("#" + anchor + " form").validate({
            ignore: ":hidden",
            success: "fa fa-check-circle valid",
            rules: {
                nickname_guest: {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                },
                nickname_registration: {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                    remote: {
                        url: "/Ядро.php?request=/users/check_nickname_no_registration",
                        type: "post",
                        data: {
                            nickname: function() {
                                return jQuery( "#nickname_registration" ).val();
                            }
                        },
                    }
                },
                nickname_authorize: {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                    remote: {
                        url: "/Ядро.php?request=/users/check_nickname_registration",
                        type: "post",
                        data: {
                            nickname: function() {
                                return jQuery( "#nickname_authorize" ).val();
                            }
                        },
                    }
                },
                password_registration: {
                    required: true,
                    minlength: 5,
                    maxlength: 100
                },
                password_authorize: {
                    required: true,
                    minlength: 5,
                    remote: {
                        url: "/Ядро.php?request=/users/check_password_valid_by_nickname",
                        type: "post",
                        data: {
                            nickname: function() {
                                return jQuery( "#nickname_authorize" ).val();
                            },
                            password: function() {
                                return jQuery( "#password_authorize" ).val();
                            }
                        },
                    }
                },
                name: {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                    russian_letters: { russian_letters: true }
                },
                family_name: {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                    russian_letters: { russian_letters: true }
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 1,
                    maxlength: 100,
                    remote: {
                        url: "/Ядро.php?request=/users/check_email_no_registration",
                        type: "post",
                        data: {
                            email: function() {
                                return jQuery( "#email" ).val();
                            }
                        },
                    }
                },
                email_guest: {
                    required: true,
                    email: true,
                    minlength: 1,
                    maxlength: 100,
                },
                message_error: {
                    required: true,
                    minlength: 1,
                    maxlength: 1000,
                }
            },
            messages: {
                nickname_guest: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                },
                nickname_registration: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                    remote: "Такой псевдоним уже занят!"
                },
                nickname_authorize: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                    remote: "Псевдоним не зарегистрирован!"
                },
                password_registration: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 5-ти символов!"
                },
                password_authorize: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 5-ти символов!",
                    remote: "Пароль не подошёл!"
                },
                name: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                    russian_letters: "Допустимы только русские буквы!"
                },
                family_name: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                    russian_letters: "Допустимы только русские буквы!"
                },
                email: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                    email: "Некорректный формат электронного адреса!",
                    remote: "Такой электронный адрес уже занят!"
                },
                email_guest: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 100-а символов!",
                    email: "Некорректный формат электронного адреса!"
                },
                message_error: {
                    required: "Поле обязательно к заполнению!",
                    minlength: "Допустимо не менее 1-го символа!",
                    maxlength: "Допустимо не более 1000-и символов!",
                }
            },
            submitHandler: function (form) {

                var request = jQuery(form).attr('action');
                var postData = jQuery(form).serialize();

                Intelligence.load_page(request,postData);

                return false;
            }
        });
    }


}

Object.defineProperty(Intelligence, 'called_core_url', {
    value: null,
    writable : true,
    enumerable : false,
    configurable : false
});