<?php

namespace Framework_life_balance\core_components\experiences;

use \Framework_life_balance\core_components\Space;
use \Framework_life_balance\core_components\Conditions;
use \Framework_life_balance\core_components\Distribution;
use \Framework_life_balance\core_components\Realization;


class Category_index
{
    static function index($parameters)
    {

        return [];

    }

    static function error($parameters){

        $code = $parameters['code'];

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
            'code'  => $code,
            'error' => $error,
        ];

    }

    static function stop($parameters)
    {

        return [];

    }

    static function engineering_works($parameters)
    {

        return [];

    }

    static function send_error($parameters)
    {

        if(isset($parameters['message_error']) and $parameters['message_error']!='' and $parameters['message_error']!='Ваша претензия'){

            $message_error = htmlspecialchars($parameters['message_error']);
            $nickname = htmlspecialchars(@$parameters['nickname_guest']);
            $email = htmlspecialchars(@$parameters['email_guest']);

            Conditions::fix_claim([
                'Претензия'          => $nickname.' ('.$email.') сообщает, что '.$message_error,
                'Файл'                  => __FILE__,
                'Номер строчки в файле' => __LINE__,
                'Заглушка страницы'     => false,
            ]);

            $message_result = 'Спасибо! Ваше сообщение доставлено в отдел разработчиков.';
        }
        else{
            $message_result = 'Привет! Если найдётся ошибка, сообщи! :)';
        }


        return [
            'msg' => $message_result
        ];

    }

    static function site_map($parameters){

        $urls = [];

        /*получаем схему наработок*/
        $schema_experiences = Space::get_mission([
            'Ключ' => 'schema_experiences',
        ]);

        if($schema_experiences != null){

            foreach($schema_experiences as $experience=>$experience_data){
                foreach($experience_data['goals'] as $experience_goal=>$experience_goal_data){

                    $url = '/'.$experience.'/'.$experience_goal;

                    if($url == '/index/index'){
                        continue;
                    }

                    if(in_array($experience_goal_data['intended'],['any','unauthorized'])){

                        $urls[$experience][$url] = $experience_goal;
                    }
                }
            }

        }



        return [
            'urls' => $urls
        ];
    }

    static function site_map_xml($parameters){

        $urls = [];

        /*получаем схему наработок*/
        $schema_experiences = Space::get_mission([
            'Ключ' => 'schema_experiences',
        ]);

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
        <loc>'.Conditions::formation_url_project([]).$url['loc'].'</loc>
        <lastmod>'.date(DATE_W3C, $url['lastmod']).'</lastmod>
        <changefreq>'.$url['changefreq'].'</changefreq>
        <priority>'.$url['priority'].'</priority>
        </url>';
        }

        $xml.= '</urlset>';

        
        return $xml;
    }

}
