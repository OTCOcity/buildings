<?php
return [
    'key' => 'standart_tech',
    'name' => 'Раздел техкарты',
    'icon' => 'file-text-o',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'in_list' => true,
                    'type' => 'input',
                ],
                [
                    'key' => 'image_photo',
                    'name' => 'Фотография',
                    'type' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 1000,
                                'height' => 800,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'image_schema',
                    'name' => 'Схема',
                    'type' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 1000,
                                'height' => 800,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'video',
                    'name' => 'Ссылка на youtube',
                    'in_list' => true,
                    'type' => 'input',
                ],
                [
                    'key' => 'text',
                    'name' => 'План',
                    'info' => 'Инфо описание длинное длинное',
                    'in_list' => true,
                    'type' => 'ckeditor',
                ],
            ],
        ],
    ],
];