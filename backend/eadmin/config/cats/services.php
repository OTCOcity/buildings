<?php
return [
    'key' => 'services',
    'name' => 'Услуги',
    'icon' => 'newspaper-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'header' => 'Баннер',
                    'name' => 'Изображениe',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'anons',
                    'name' => 'Анонс',
                    'type' => 'textarea',
                ],

                [
                    'key' => 'text',
                    'header' => 'Текст на странице',
                    'name' => 'Текст на странице',
                    'type' => 'ckeditor',
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
                ],
            ],
        ],
        [
            'name' => 'Услуги',
            'icon' => 'newspaper-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'services',
        ],

    ],
];