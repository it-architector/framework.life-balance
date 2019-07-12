class Conditions {

    static initiation($parameters) {

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
            Conditions.height_scroll_bar({});
        });

        jQuery(window).resize(function(){
            Conditions.height_scroll_bar({});
        });


        /* Форма для ошибок*/

        document.getElementById("input_message_error").onblur = function() {
            if (this.value === ''){
                this.value = 'Ваша претензия';
            }
        };

        document.getElementById("input_message_error").onfocus = function() {
            if (this.value === 'Ваша претензия'){
                this.value = '';
            }
        };

        document.getElementById("input_nickname_guest").onblur = function() {
            if (this.value === ''){
                this.value = 'Ваш псевдоним';
            }
        };

        document.getElementById("input_nickname_guest").onfocus = function() {
            if (this.value === 'Ваш псевдоним'){
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

    static height_scroll_bar($parameters){
        if ($(window).width() > 991){
            var wh = jQuery('footer').height() + 70;
            jQuery('#contacts').css('min-height', wh);
        }

    }

    static save_called_core_url($parameters) {

        var url = $parameters['url'];

        if(url!==''){
            this.called_core_url = url;
        }
    }

    static get_called_core_url($parameters) {
        return this.called_core_url;
    }

    static get_url_by_opened_page($parameters){

        var open_page = '';

        if(window.location.pathname !== undefined){
            open_page = open_page + window.location.pathname;
        }

        if(window.location.search !== undefined){
            open_page = open_page + window.location.search;
        }

        if(window.location.hash !== undefined){
            open_page = open_page + window.location.hash;
        }

        if(open_page == ''){
            open_page = '/';
        }

        return open_page;

    }

    static get_category_by_page_link($parameters) {

        var link = $parameters['link'];

        var link_explode = link.split('#',2);

        link = link_explode[0];

        link_explode = link.split('/',3);

        return link_explode[1];

    }

    static get_goal_by_page_link($parameters) {

        var link = $parameters['link'];

        var link_explode = link.split('#',2);

        link = link_explode[0];

        link_explode = link.split('/',3);

        return link_explode[2];

    }

    static formation_core_url($parameters) {

        var link = $parameters['link'];

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

    static navigation_to_page_anchor($parameters) {
        if(window.location.hash!==""){
            if(jQuery(window.location.hash).offset() !== undefined){
                var scrollTop = jQuery(window.location.hash).offset().top - 80;
                jQuery('html, body').animate({scrollTop: scrollTop}, 1000);
            }
        }
    }

    static show_authorization_panel($parameters) {

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

    static show_loader($parameters) {

        jQuery('#content').slideToggle('slow');
        jQuery('#preloader').show();

    }

    static show_content($parameters) {

        var category = $parameters['category'];
        var goal = $parameters['goal'];
        var response = $parameters['response'];

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
        else if(typeof(site_functions[category]) != "undefined" && typeof(site_functions[category][goal]) != "undefined"){

            content_body = this.packaging_core_data({
                'category': category,
                'goal': goal,
            });

        }

        setTimeout(function() {

            jQuery('#preloader').hide();
            jQuery('#content').html(content_body).slideDown('slow');

            /* Выполняем функцию страницы */
            if(typeof(window["Category_" + category]) != "undefined" && typeof(window["Category_" + category][goal]) != "undefined"){
                window["Category_" + category][goal](response["content"]);
            }

            /* переводим ссылки на core режим */
            Conditions.communication_link_with_core({
                'anchor': '#content a.to_core',
            });

            /* переводим формы на core режим */
            Conditions.communication_form_with_core({
                'anchor': 'content',
            });

            /*переходим на якорь*/
            setTimeout(function(){
                Conditions.navigation_to_page_anchor({});
            },800);

        }, 800);

    }

    static show_error($parameters) {

        var error = $parameters['error'];

        jQuery('#preloader').hide();
        jQuery('#content').html('<div style="padding: 30px;">' + error + '</div>').slideDown('slow');
    }

    static load_page($parameters) {

        var page_link = $parameters['page_link'];
        var post_data = $parameters['post_data'];

        if(page_link == '/undefined'){
            page_link = '/';
        }

        var category = this.get_category_by_page_link({
            'link': page_link
        });

        var goal = this.get_goal_by_page_link({
            'link': page_link
        });

        var core_last_url = this.get_called_core_url({});

        var core_url = this.formation_core_url({
            'link': page_link
        });

        this.save_called_core_url({
            'url': core_url,
        });

        /*отправляем данные в ядро по post*/
        if(core_url !== '' && (core_last_url !== core_url || (core_last_url === core_url && window.location.hash === ""))){

            /* показываем анимацию загрузки данных */
            this.show_loader({});

            this.load_core_data({
                'category': category,
                'goal': goal,
                'core_url': core_url,
                'post_data': post_data,
            });

        }
        else{
            /*переходит на якорь*/
            this.navigation_to_page_anchor({});
        }

    }

    static load_core_data($parameters) {

        var category = $parameters['category'];
        var goal = $parameters['goal'];
        var core_url = $parameters['core_url'];
        var post_data = $parameters['post_data'];

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
                    Conditions.show_error({
                        'error': response,
                    });
                }

                category = response["category"];
                goal = response["goal"];

                Conditions.show_content({
                    'category': category,
                    'goal': goal,
                    'response': response,
                });


            }
            /* Ответ текстом */
            catch (e){
                Conditions.show_content({
                    'category': category,
                    'goal': goal,
                    'response': response_text,
                });
            }

        }
        else {
            Conditions.show_error({
                'error': request.status + ': ' + request.statusText,
            });
        }

    }

    static packaging_core_data($parameters){

        var category = $parameters['category'];
        var goal = $parameters['goal'];

        /*ссылка на шаблон html*/
        var html_file_url = '/Компоненты интерфейса/3.Распределение/Элементы/Элементы тэгов/Элементы тэгов ' + category + '/' + goal + '.html';

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

    static communication_link_with_core($parameters) {

        var anchor = $parameters['anchor'];

        jQuery(anchor).click(function(){

            var page_link = jQuery(this).attr('href');

            history.pushState(null, null, page_link);

            Conditions.load_page({
                'page_link': page_link,
                'post_data': '',
            });

            return false;

        });
    }

    static communication_form_with_core($parameters) {

        var anchor = $parameters['anchor'];

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

                Conditions.load_page({
                    'page_link': request,
                    'post_data': postData,
                });

                return false;
            }
        });
    }


}

Object.defineProperty(Conditions, 'called_core_url', {
    value: null,
    writable : true,
    enumerable : false,
    configurable : false
});