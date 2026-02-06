<?php
return [
    'key' => 'main_catalog',
    'name' => 'Разделы на главной странице',
    'icon' => 'navicon',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 800,
                                'height' => 600,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'type' => 'textarea',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ],
                ],
                [
                    'key' => 'anons',
                    'name' => 'Краткое описание',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'url',
                    'name' => 'Ссылка на раздел',
                    'type' => 'input',
                ],
            ],
        ],
    ],
];