<?php

namespace Framework_life_balance\core_components\experiences;

use \Framework_life_balance\core_components\Notices;
use \Framework_life_balance\core_components\Solutions;
use \Framework_life_balance\core_components\Resources;
use \Framework_life_balance\core_components\Business;


class Index
{
    function index(array $parameters)
    {

        return [];

    }

    function error(array $parameters)
    {

        $code = isset($parameters['code'])?$parameters['code']:'';

        switch($code){
            case 'no_experience_class':
                $error = 'По техническим причинам запрошенная страница больше не доступна.';
                break;
            case 'no_experience_goal':
                $error = 'По техническим причинам запрошенная страница больше не доступна.';
                break;
            case 'no_html_file':
                $error = 'По техническим причинам у запрошенной страницы нет html для выдачи.';
                break;
            case 'array_result_on_html_format':
                $error = 'По техническим причинам страница не может выдать данные в главный шаблон.';
                break;
            case 'no_structure':
                $error = 'Техническая неполадка в получении Структуры запрошенного пользователем метода.';
                break;
            case 'only_unauthorized':
                $error = 'Доступ только для неавторизованных пользователей.';
                break;
            case 'only_authorized':
                $error = 'Доступ только для авторизованных пользователей.';
                break;
            case 'only_authorized_by_admin':
                $error = 'Доступ только для администраторов.';
                break;
            case 'only_console':
                $error = 'Доступ только с консоли.';
                break;
            default:
                $code = '0';
                $error = 'Техническая неполадка сайта.';
                break;
        }

        return [
            'code' => $code,
            'error' => $error,
        ];

    }

    function stop(array $parameters)
    {

        return [];

    }

    function engineering_works(array $parameters)
    {

        return [];

    }

    function send_error(array $parameters)
    {

        if(isset($parameters['message_error']) and $parameters['message_error']!='' and $parameters['message_error']!='Сообщение об ошибке'){

            $message_error = htmlspecialchars($parameters['message_error']);
            $nickname = htmlspecialchars(@$parameters['nickname_guest']);
            $email = htmlspecialchars(@$parameters['email_guest']);

            Business::fix_error($nickname.' ('.$email.') сообщает, что '.$message_error, __FILE__, __LINE__, false);

            $message_result = 'Спасибо! Ваше сообщение доставлено в отдел разработчиков.';
        }
        else{
            $message_result = 'Привет! Если найдётся ошибка, сообщи! :)';
        }


        return [
            'msg' => $message_result
        ];

    }


    function site_map(array $parameters){

        $urls = [];

        /*получаем схему наработок*/
        $schema_experiences = Notices::get_mission('schema_experiences');

        if($schema_experiences != null){

            foreach($schema_experiences as $experience=>$experience_data){
                foreach($experience_data['goals'] as $experience_goal=>$experience_goal_data){

                    $url = '/'.$experience.'/'.$experience_goal;

                    if($url == '/index/index'){
                        continue;
                    }

                    if(in_array($experience_goal_data['intended'],['any','unauthorized'])){

                        $urls[$experience_data['description']][$url] = $experience_goal_data['description'];
                    }
                }
            }

        }



        return [
            'urls' => $urls
        ];
    }

    function site_map_xml(array $parameters){

        $urls = [];

        /*получаем схему наработок*/
        $schema_experiences = Notices::get_mission('schema_experiences');

        if($schema_experiences!=null){

            foreach($schema_experiences as $experience=>$experience_data){
                foreach($experience_data['goals'] as $experience_goal=>$experience_goal_data){

                    $url = '/'.$experience.'/'.$experience_goal;

                    if($url == '/index/index'){
                        continue;
                    }

                    if(in_array($experience_goal_data['intended'],['any','unauthorized'])){

                        $urls[] = [
                            'loc' => $url,
                            'lastmod' => time(),
                            'changefreq' => 'daily',
                            'priority' => '1.0'
                        ];
                    }
                }
            }

        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.w3.org/1999/xhtml http://www.w3.org/2002/08/xhtml/xhtml1-strict.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        foreach ($urls as $url){
            $xml.='<url>
        <loc>'.Solutions::formation_url_project().$url['loc'].'</loc>
        <lastmod>'.date(DATE_W3C, $url['lastmod']).'</lastmod>
        <changefreq>'.$url['changefreq'].'</changefreq>
        <priority>'.$url['priority'].'</priority>
        </url>';
        }

        $xml.= '</urlset>';

        
        return $xml;
    }

}
