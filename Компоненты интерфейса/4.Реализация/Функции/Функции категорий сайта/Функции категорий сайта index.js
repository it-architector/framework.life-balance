class Category_index{

    static index($parameters){

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

    static error($parameters){

        /*данные ошибки*/
        $('.flex_caption1').html('<p class="navmenu title3 captionDelay7 FromBottom color_white">Ошибка*:</p>\n' +
            '                    <p class="navmenu title4 captionDelay7 FromBottom color_white">' + $parameters['error'] + '</p>\n' +
            '                    <br><br>\n' +
            '                    <p class="navmenu title6 captionDelay7 FromBottom color_white">* текущая информация отправлена в отдел разрабочиков для изучения. Спасибо!</p>\n');

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

    static stop($parameters){

        /*данные ошибки*/
        $('.flex_caption1').html('<p class="navmenu title3 captionDelay7 FromBottom color_white">Ваш запрос отвергнут*</p>\n' +
            '                    <br><br>\n' +
            '                    <p class="navmenu title6 captionDelay7 FromBottom color_white">* текущая информация отправлена в отдел разрабочиков для изучения. Спасибо!</p>\n');

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

    static engineering_works($parameters){
        /*данные ошибки*/
        $('.flex_caption1').html('<p class="navmenu title3 captionDelay7 FromBottom color_white">Техническая работа*</p>\n' +
            '                    <br><br>\n' +
            '                    <p class="navmenu title6 captionDelay7 FromBottom color_white">* приходите через ~ 1 минуту.</p>\n');


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

    static send_error($parameters){

        /*выдача сообщения*/
        $('.row.recent_posts').html($parameters['msg']);

        $('#contact-form-face input[name="message_error"]').val('Ваша претензия');

    }

    static site_map($parameters){

        /*данные карты*/
        var out_maps = '';
        
        $.each($parameters['urls'], function(modelInfo, methods) {

            out_maps = out_maps + '<p class="navmenu title4 captionDelay7 FromBottom color_white">' + modelInfo + '</p><p class="navmenu title5 captionDelay7 FromBottom color_white">';

            $.each(methods, function(methodUrl, methodInfo) {

                out_maps = out_maps + '- <a class="color_white" href="' + methodUrl + '">' + methodInfo + '</a><br>';

            });

            out_maps = out_maps + '</p>';


        });
        $('.flex_caption1').html(out_maps);

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

}

window['Category_index'] = Category_index;