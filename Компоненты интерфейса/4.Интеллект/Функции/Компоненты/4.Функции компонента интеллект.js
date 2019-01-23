class Intelligence {

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

    /* формируем ссылки для передачи запроса в ядро */
    static formation_core_url(request) {

        var core_url = '';
        var request_explode = request.split('#',2);

        /*отмечаем что есть запрос к ядру*/
        if(request_explode[0]!==''){
            var request_link = request_explode[0].replace("?", "&");
            var core_url = "/Ядро.php?request=" + request_link;
        }

        /*отмечаем переход на якорь*/
        if(typeof(request_explode[1]) != "undefined"){
            window.location.hash = request_explode[1];
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
    static show_content(content) {

        setTimeout(function() {

            jQuery('#preloader').hide();
            jQuery('#content').html(content).slideDown('slow');

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
        alert('При запросе произошла ошибка. Повторите пожалуйста!');
    }

    /* загружает данные */
    static get_data_from_core(request,postData) {

        var core_last_url = this.get_called_core_url();
        var core_url = this.formation_core_url(request);

        this.save_called_core_url(core_url);

        /*отправляем данные в ядро по post*/
        if(core_url!=='' && (core_last_url!==core_url || (core_last_url==core_url && window.location.hash == ""))){

            /* показываем анимацию загрузки данных */
            this.show_loader();

            jQuery.post(core_url,postData).done(function(values){

                /*устанавливаем заголовок*/
                if(typeof(values["title"]) != "undefined"){
                    jQuery('title').text(values["title"]);
                }

                /*устанавливаем короткое описание*/
                if(typeof(values["description"]) != "undefined"){
                    jQuery('meta[name=description]').attr('content', values["description"]);
                }

                /*устанавливаем ключевые слова*/
                if(typeof(values["keywords"]) != "undefined"){
                    jQuery('meta[name=keywords]').attr('content', values["keywords"]);
                }

                /*отвечающий*/
                if(typeof(values["responding"]) == "undefined"){
                    Intelligence.show_error(values);
                }
                /*обёртываем в html*/
                else if(typeof(list_blocks[values["responding"]]) != "undefined"){

                    /*массив полученных данных*/
                    if(typeof(values["content"]) != "undefined"){
                        Intelligence.content_core = values["content"];
                    }
                    else{
                        Intelligence.content_core = [];
                    }

                    /*ссылка на шаблон html*/
                    var html_file = '/Компоненты интерфейса/3.Ресурсы/Блоки' + values["responding"] + '.html';

                    jQuery.get(html_file).done(function(content){
                        Intelligence.show_content(content);
                    }).fail(function(xhr, status, error) {
                        Intelligence.show_error(error);
                    });

                }
                else if(typeof(values["content"]) != "undefined"){
                    Intelligence.show_content(values["content"]);
                }
                else{
                    Intelligence.show_error('');
                }

            }).fail(function(xhr, status, error) {
                Intelligence.show_error(error);
            });

        }
        else{
            /*переходит на якорь*/
            this.navigation_to_page_anchor();
        }

    }

    /* переводим ссылки на core режим */
    static communication_link_with_core(anchor) {

        jQuery(anchor).click(function(){

            var request = jQuery(this).attr('href');

            history.pushState(null, null, request);

            Intelligence.get_data_from_core(request,'');

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

                Intelligence.get_data_from_core(request,postData);

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

Object.defineProperty(Intelligence, 'content_core', {
    value: [],
    writable : true,
    enumerable : false,
    configurable : false
});