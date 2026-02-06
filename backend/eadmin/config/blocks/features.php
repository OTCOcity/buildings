<?php
return [
    'key' => 'features',
    'name' => 'Преимущества',
    'icon' => 'plus-circle',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'main_image',
                    'name' => 'Изображения',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 800,
                                'height' => 600,
                                'type' => 'bestfit',
                            ],
                            'small' => [
                                'width' => 320,
                                'height' => 240,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Имя',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'text',
                    'name' => 'Описание ',
                    'type' => 'ckeditor',
                    'in_list' => true,
                ],
            ],
        ],
    ],
];