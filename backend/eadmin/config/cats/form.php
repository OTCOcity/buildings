<?php
return [
    'key' => 'form',
    'name' => 'Обратная связь',
    'icon' => 'envelope-o',
    'tabs' => [
//        [
//            'name' => 'Информация',
//            'icon' => 'info',
//            'color' => 'orange',
//            'fields' => [
//                [
//                    'key' => 'text',
//                    'name' => 'Текст на странице',
//                    'type' => 'ckeditor',
//                    'lang' => true
//                ],
//            ],
//        ],

//        [
//            'name' => 'Обратная связь',
//            'icon' => 'phone',
//            'color' => 'blue',
//            'count_color' => 'primary',
//            'inner_blocks' => 'os_call',
//        ],
        [
            'name' => 'Письма',
            'icon' => 'envelope-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'os_feedback',
        ],
    ],
];