<?php
return [
    'key' => 'news',
    'name' => 'Новости',
    'icon' => 'newspaper-o',
    'tabs' => [
//        [
//            'name' => 'Инфо',
//            'icon' => 'info',
//            'color' => 'orange',
//            'fields' => [
//                [
//                    'key' => 'image',
//                    'name' => 'Изображениe',
//                    'type' => 'image',
//                    'options' => [
//                        'count' => 1,
//                        'resize' => [
//                            'big' => [
//                                'width' => 1200,
//                                'height' => 1200,
//                                'type' => 'bestfit',
//                            ],
//                        ],
//                    ],
//                ],
//                [
//                    'key' => 'name',
//                    'name' => 'Заголовок',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'anons',
//                    'name' => 'Анонс',
//                    'type' => 'textarea',
//                ],
//
//                [
//                    'key' => 'text',
//                    'name' => 'Текстовое описание',
//                    'type' => 'ckeditor',
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
//                ],
//            ],
//        ],

        [
            'name' => 'Новости',
            'icon' => 'file-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'news',
        ],
    ],
];