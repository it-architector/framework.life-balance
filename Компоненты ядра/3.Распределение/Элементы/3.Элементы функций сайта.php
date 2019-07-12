<?php

return array(

    'index'    => [

        'goals' => array(

            'index' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => [],
            ],
             
            'error' => [
                'Входящие переменные'  => [
                    'code' => null,
                ],
                'Выходящие переменные' => array('code','error'),
            ],
            
            'stop' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => [],
            ],
            
            'engineering_works' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => [],
            ],
             
            'send_error' => [
                'Входящие переменные'  => [
                    'message_error'  => null,
                    'nickname_guest' => null,
                    'email_guest'    => null,
                ],
                'Выходящие переменные' => array('msg'),
            ],
             
            'site_map' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => array('urls'),
            ],
            
            'site_map_xml' => [
                'Входящие переменные'  => [],
            ],
        )
    ],
    'users'    => [

        
        'goals' => array(

             
            'index' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => array('users'),
            ],
             
            'registration' => [
                'Входящие переменные'  => [
                    'nickname_registration' => null,
                    'name'                  => null,
                    'family_name'           => null,
                    'email'                 => null,
                    'password_registration' => null,
                ],
                'Выходящие переменные' => array('nickname','name','family_name','password','email','registration_error'),
            ],
             
            'registration_ok' => [
                'Входящие переменные'  => [
                    'nickname' => null,
                    'password' => null,
                ],
                'Выходящие переменные' => array('nickname','password'),
            ],
             
            'authorize' => [
                'Входящие переменные'  => [
                    'nickname_authorize' => null,
                    'password_authorize' => null,
                ],
                'Выходящие переменные' => array('nickname','password'),
            ],
            
            'authorized_ok' => [
                'Входящие переменные'  => [
                    'user_id'      => null,
                    'user_session' => null,
                ],
                'Выходящие переменные' => array('user_id','user_session'),
            ],
            
            'authorized_data' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => array('user_data'),
            ],
             
            'unauthorize' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => [],
            ],
             
            'unauthorized_ok' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => [],
            ],
             
            'check_nickname_registration' => [
                'Входящие переменные'  => [
                    'nickname' => null,
                ],
            ],
            
            'check_nickname_no_registration' => [
                'Входящие переменные'  => [
                    'nickname' => null,
                ],
            ],
             
            'check_password_valid_by_nickname' => [
                'Входящие переменные'  => [
                    'nickname' => null,
                    'password' => null,
                ],
            ],
             
            'check_email_no_registration' => [
                'Входящие переменные'  => [
                    'email' => null,
                ],
            ],
        )
    ],
    'control'  => [

        
        'goals' => array(

            
            'index' => [
                'Входящие переменные'  => [],
                'Выходящие переменные' => [
                    'last_error_in_file_log' => [
                        'date',
                        'request_experience',
                        'request_experience_goal',
                        'user_ip',
                        'error_message',
                        'file_name',
                        'num_line_on_file_error',
                    ],
                ],
            ],
            
            'errors' => [
                'Входящие переменные'  => [
                    'delete_file_log' => null,
                ],
                'Выходящие переменные' => [
                    'errors_in_file_log' => [
                        0 => [
                            'date',
                            'request_experience',
                            'request_experience_goal',
                            'user_ip',
                            'error_message',
                            'file_name',
                            'num_line_on_file_error',
                        ]
                    ],
                ],
            ],
            
            'reassembly_data_base' => [
                'Входящие переменные'  => [],
            ],
            
            'send_email' => [
                'Входящие переменные'  => array(
                    'email'    => null,
                    'title'    => null,
                    'text'     => null,
                    'template' => null,
                ),
            ],
        )
    ],

);


?>
