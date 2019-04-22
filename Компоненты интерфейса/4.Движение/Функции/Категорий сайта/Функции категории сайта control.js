class Category_control{

    static index($parameters){
        /*данные ошибки добаления пользователя*/
        $('#add-user-msg').html($parameters['msg_add_user']);

        /*последняя ошибка в файле лога*/
        if($parameters['last_error_in_file_log']==false){
            var last_error_in_file_log = 'Нет.';
        }
        else{
            var last_error_in_file_log = $parameters['last_error_in_file_log']['date'] + ' (' + $parameters['last_error_in_file_log']['request_experience'] + '/' + $parameters['last_error_in_file_log']['request_experience_goal'] + '): ' + $parameters['last_error_in_file_log']['error_message'];
        }
        $('#last_error_in_file_log').html(last_error_in_file_log);

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

    static errors($parameters){

        var out_errors_in_file_log = '';

        /*ошибки из файла лога*/
        if($parameters['errors_in_file_log'] === null){
            out_errors_in_file_log = 'Нет.';
        }

        else{
            $.each($parameters['errors_in_file_log'], function(error_id, error) {

                out_errors_in_file_log = out_errors_in_file_log + '<p>' + error['date'] + ' (' + error['request_experience'] + '/' + error['request_experience_goal'] + '): ' + error['error_message'] + '</p>';

            });

            out_errors_in_file_log = out_errors_in_file_log + '<p><u><a class="to_core" href="/control/errors?delete_file_log=true">Очистить файл лога</a></u></p>';
        }

        $('#out_errors_in_file_log').html(out_errors_in_file_log);


    }
}

window['Category_control'] = Category_control;