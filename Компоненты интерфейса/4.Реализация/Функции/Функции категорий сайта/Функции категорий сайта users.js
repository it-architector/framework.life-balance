class Category_users{

    static index($parameters){
        /*данные пользователей*/
        var out_users = '';

        if($parameters['users']==false){
            out_users = 'Пока никого! Кто первый зарегистрируется тот будет администратором!';
        }
        else{
            $.each($parameters['users'], function(user_id, user) {

                if(user['is_admin'] == 'true'){
                    var status = 'администратор';
                }
                else{
                    var status = 'пользователь';
                }

                out_users = out_users + '<div class="col-lg-4 col-md-4 col-sm-4 padbot30 post_item_block">\n' +
                    '            <div class="post_item"></div>\n' +
                    '            <div class="post_item_content">\n' +
                    '            <a class="title" href="#" >' + user['nickname'] + '</a>\n' +
                    '        <ul class="post_item_inf">\n' +
                    '            <li>id: ' + user['id'] + ' |</li>\n' +
                    '        <li>' + status + '</li>\n' +
                    '        </ul>\n' +
                    '        </div>\n' +
                    '        </div>';


            });
        }

        $('.row.recent_posts').html(out_users);
    }

    static authorize($parameters){
        if($parameters['nickname']!=''){
            $('#nickname_authorize').val($parameters['nickname']);
        }
        if($parameters['password']!=''){
            $('#password_authorize').val($parameters['password']);
        }

        /*данные ошибки*/
        if($parameters['authorize_error']!=''){

            $('#authorize_message_error').html($parameters['authorize_error']);
            $('#authorize_message_error').show();
        }

        /*-----------------------------------------------------------------------------------*/
        /*	FLEXSLIDER
        /*-----------------------------------------------------------------------------------*/
        $('.flexslider.top_slider').flexslider({
            animation: "fade",
            controlNav: false,
            directionNav: false,
            animationLoop: false,
            slideshow: false,
            prevText: "",
            nextText: "",
            sync: "#carousel"
        });
        $('#carousel').flexslider({
            animation: "fade",
            controlNav: false,
            animationLoop: false,
            directionNav: false,
            slideshow: false,
            itemWidth: 100,
            itemMargin: 5,
            asNavFor: '.top_slider'
        });


        jQuery('.flexslider.top_slider .flex-direction-nav').addClass('container');


        //Vision Slider
        $('.flexslider.portfolio_single_slider').flexslider({
            animation: "fade",
            controlNav: true,
            directionNav: true,
            animationLoop: false,
            slideshow: false,
        });


        var wh = jQuery(window).height() - 80;
        jQuery('.top_slider, .top_slider .slides li').css('height', wh);

    }

    static authorized_ok($parameters){

        /*сохраняем авторизацию*/
        $.cookie('user_id', $parameters['user_id'], { expires: 120, path: '/', });
        $.cookie('user_session', $parameters['user_session'], { expires: 120, path: '/', });

        /*меняем ссылки авторизации*/
        Conditions.show_authorization_panel({});

    }

    static registration($parameters){

        if($parameters['nickname']!=''){
            $('#nickname_registration').val($parameters['nickname']);
        }
        if($parameters['name']!=''){
            $('#name').val($parameters['name']);
        }
        if($parameters['family_name']!=''){
            $('#family_name').val($parameters['family_name']);
        }
        if($parameters['email']!=''){
            $('#email').val($parameters['email']);
        }
        if($parameters['password']!=''){
            $('#password_registration').val($parameters['password']);
        }

        /*данные ошибки*/
        if($parameters['registration_error']!=''){

            $('#registration_message_error').html($parameters['registration_error']);
            $('#registration_message_error').show();
        }

        /*-----------------------------------------------------------------------------------*/
        /*	FLEXSLIDER
        /*-----------------------------------------------------------------------------------*/
        $('.flexslider.top_slider').flexslider({
            animation: "fade",
            controlNav: false,
            directionNav: false,
            animationLoop: false,
            slideshow: false,
            prevText: "",
            nextText: "",
            sync: "#carousel"
        });
        $('#carousel').flexslider({
            animation: "fade",
            controlNav: false,
            animationLoop: false,
            directionNav: false,
            slideshow: false,
            itemWidth: 100,
            itemMargin: 5,
            asNavFor: '.top_slider'
        });


        jQuery('.flexslider.top_slider .flex-direction-nav').addClass('container');


        //Vision Slider
        $('.flexslider.portfolio_single_slider').flexslider({
            animation: "fade",
            controlNav: true,
            directionNav: true,
            animationLoop: false,
            slideshow: false,
        });


        var wh = jQuery(window).height() - 80;
        jQuery('.top_slider, .top_slider .slides li').css('height', wh);
    }

    static registration_ok($parameters){

        /*данные регистрации*/
        $('#registration_nickname').html($parameters['nickname']);
        $('#registration_password').html($parameters['password']);
    }

    static unauthorized_ok($parameters){
        
        /*стираем авторизацию*/
        $.cookie('user_id', null, { expires: -1, path: '/', });
        $.cookie('user_session', null, { expires: -1, path: '/', });

        /*меняем ссылки авторизации*/
        Conditions.show_authorization_panel({});
    }

}

window['Category_users'] = Category_users;