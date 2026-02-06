<?php
return [
    'key' => 'manager',
    'name' => 'Специалист',
    'icon' => 'user',
    'tabs' => [
        [
            'name' => 'Данные',
            'icon' => 'info',
            'color' => 'user',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Фото',
                    'type' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 250,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Имя',
                    'type' => 'input',
                    'lang' => true,
                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
                ],
//                [
//                    'key' => 'post',
//                    'name' => 'Должность',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
                [
                    'key' => 'phone',
                    'name' => 'Контакты',
                    'type' => 'input',
                    'in_list' => true,
                ],
//                [
//                    'key' => 'whats_app',
//                    'name' => 'WhatsApp',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'text',
//                    'name' => 'Прочая информация',
//                    'type' => 'ckeditor',
//                ],
            ],
        ],
    ],
];