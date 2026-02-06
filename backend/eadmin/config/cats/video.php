<?php
return [
    'key' => 'video',
    'name' => 'Видео',
    'icon' => 'video-camera',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
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
                [
                    'key' => 'text',
                    'name' => 'Текстовое описание',
                    'type' => 'ckeditor',
                    'lang' => true,
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
            'name' => 'Видео',
            'icon' => 'video-camera',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'video',
        ],
    ],
];