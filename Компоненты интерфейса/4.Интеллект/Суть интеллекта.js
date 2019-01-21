/*запоминаем запрос*/
function framework_life_balance_saveCoreUrl(url) {
    if(url!==''){
        framework_life_balance_lastCoreUrl = url;
    }
}

/*получаем последний запрос*/
function framework_life_balance_getLastCoreUrl() {
    return framework_life_balance_lastCoreUrl;
}

/* формируем ссылки для передачи запроса в ядро */
function framework_life_balance_urlToCore(request) {

    var urlToCOre = '';
    var request_explode = request.split('#',2);

    /*отмечаем что есть запрос к ядру*/
    if(request_explode[0]!==''){
        var request_link = request_explode[0].replace("?", "&");
        var urlToCOre = "/Ядро.php?request=" + request_link;
    }

    /*отмечаем переход на якорь*/
    if(typeof(request_explode[1]) != "undefined"){
        window.location.hash = request_explode[1];
    }
    else{
        window.location.hash = "";
    }

    return urlToCOre;
}

/*переходит на якорь*/
function framework_life_balance_goToAnchor() {
    if(window.location.hash!==""){
        if($(window.location.hash).offset() !== undefined){
            var scrollTop = $(window.location.hash).offset().top - 80;
            $('html, body').animate({scrollTop: scrollTop}, 1000);
        }
    }
}

/* показываем авторизацию */
function framework_life_balance_showAuth() {

    $.post('/Ядро.php?request=/users/authorized_data','').done(function(values){

        if(values!=false && typeof(values['content']['user_data']['nickname']) != "undefined"){
            $('#authed-url').html('<i class="fa fa-user"></i> ' + values['content']['user_data']['nickname']);
            $('#auth-menu').fadeOut('slow');
            setTimeout(function() {
                $('#authed-menu').fadeIn('slow');
            },1000);

            if(values['content']['user_data']['is_admin']=='true'){
                $('#control-menu').fadeIn('slow');
            }
            else{
                $('#control-menu').fadeOut('slow');
            }

        }
        else{
            $('#authed-menu').fadeOut('slow');
            setTimeout(function() {
                $('#auth-menu').fadeIn('slow');
            },1000);
            $('#control-menu').fadeOut('slow');
        }
    }).fail(function(xhr, status, error) {
        $('#authed-menu').fadeOut('slow');
        setTimeout(function() {
            $('#auth-menu').fadeIn('slow');
        },1000);
        $('#control-menu').fadeOut('slow');
    });

}

/* показываем анимацию загрузки данных */
function framework_life_balance_showLoader() {

    $('#content').slideToggle('slow');
    $('#preloader').show();

}

/* показываем загруженные данные */
function framework_life_balance_showContent(content) {

    setTimeout(function() {

        $('#preloader').hide();
        $('#content').html(content).slideDown('slow');

        /* переводим ссылки на core режим */
        framework_life_balance_transferLinkToCore('#content a.to_core');
        /* переводим формы на core режим */
        framework_life_balance_transferFormToCore('content');

        /*переходим на якорь*/
        setTimeout(function(){
            framework_life_balance_goToAnchor();
        },800);

    }, 800);

}

/* показываем ошибку работы ajax */
function framework_life_balance_showError(error) {
    $('#preloader').hide();
    $('#content').html('<div style="padding: 30px;">' + error + '</div>').slideDown('slow');
    alert('При запросе произошла ошибка. Повторите пожалуйста!');
}

/* загружает данные */
function framework_life_balance_loadDataFromCore(request,postData) {

    var urlToCoreLast = framework_life_balance_getLastCoreUrl();
    var urlToCore = framework_life_balance_urlToCore(request);

    framework_life_balance_saveCoreUrl(urlToCore);

    /*отправляем данные в ядро по post*/
    if(urlToCore!=='' && (urlToCoreLast!==urlToCore || (urlToCoreLast==urlToCore && window.location.hash == ""))){

        /* показываем анимацию загрузки данных */
        framework_life_balance_showLoader();

        $.post(urlToCore,postData).done(function(values){

            /*устанавливаем заголовок*/
            if(typeof(values["title"]) != "undefined"){
                $('title').text(values["title"]);
            }

            /*устанавливаем короткое описание*/
            if(typeof(values["description"]) != "undefined"){
                $('meta[name=description]').attr('content', values["description"]);
            }

            /*устанавливаем ключевые слова*/
            if(typeof(values["keywords"]) != "undefined"){
                $('meta[name=keywords]').attr('content', values["keywords"]);
            }

            /*отвечающий*/
            if(typeof(values["responding"]) == "undefined"){
                framework_life_balance_showError(values);
            }
            /*обёртываем в html*/
            else if(typeof(framework_life_balance_htmlOnRequestsToCore[values["responding"]]) != "undefined"){

                /*массив полученных данных*/
                if(typeof(values["content"]) != "undefined"){
                    framework_life_balance_answer_content = values["content"];
                }
                else{
                    framework_life_balance_answer_content = [];
                }

                /*ссылка на шаблон html*/
                var html_file = '/Компоненты интерфейса/3.Ресурсы/Блоки' + values["responding"] + '.html';

                $.get(html_file).done(function(content){
                    framework_life_balance_showContent(content);
                }).fail(function(xhr, status, error) {
                    framework_life_balance_showError(error);
                });

            }
            else if(typeof(values["content"]) != "undefined"){
                framework_life_balance_showContent(values["content"]);
            }
            else{
                framework_life_balance_showError('');
            }

        }).fail(function(xhr, status, error) {
            framework_life_balance_showError(error);
            });

    }
    else{
        /*переходит на якорь*/
        framework_life_balance_goToAnchor();
    }

}

/* переводим ссылки на core режим */
function framework_life_balance_transferLinkToCore(anchor) {

    $(anchor).click(function(){

        var request = $(this).attr('href');

        history.pushState(null, null, request);

        framework_life_balance_loadDataFromCore(request,'');

        return false;

    });
}

/* переводим формы на core режим */
function framework_life_balance_transferFormToCore(anchor) {

    $("#" + anchor + " form").validate({
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
                            return $( "#nickname_registration" ).val();
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
                            return $( "#nickname_authorize" ).val();
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
                            return $( "#nickname_authorize" ).val();
                        },
                        password: function() {
                            return $( "#password_authorize" ).val();
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
                            return $( "#email" ).val();
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

            var request = $(form).attr('action');
            var postData = $(form).serialize();

            framework_life_balance_loadDataFromCore(request,postData);

            return false;
        }
    });
}

