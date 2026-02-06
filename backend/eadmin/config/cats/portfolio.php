<?php
return [
    'key' => 'portfolio',
    'name' => 'Портфолио',
    'icon' => 'paint-brush',
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
                    'key' => 'name',
                    'name' => 'Заголовк',
                    'type' => 'input',
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],

                [
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],


            ],
        ],
        [
            'name' => 'Работы',
            'icon' => 'paint-brush',
            'color' => 'green',
            'count_color' => 'success',
            'inner_blocks' => 'portfolio',
        ],
    ],
];