<?php
return [
    'key' => 'standart_extra_schema',
    'name' => 'Доп. чертежи',
    'icon' => 'file-text-o',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Название',
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
//                [
//                    'key' => 'video_anons',
//                    'name' => 'Подпись к видео',
//                    'in_list' => true,
//                    'type' => 'textarea',
//                ],
            ],
        ],
    ],
];