<?php
return [
    'key' => 'price',
    'name' => 'Прайс',
    'icon' => 'money',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображениe',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 1200,
                                'height' => 1200,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'file',
                    'name' => 'Прайс для скачивания',
                    'type' => 'file',
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
                    'name' => 'Текстовое описание',
                    'type' => 'ckeditor',
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
            ],
        ],
        [
            'name' => 'Прайс',
            'icon' => 'money',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'price',
        ],
    ],
];