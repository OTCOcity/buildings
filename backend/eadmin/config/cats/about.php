<?php
return [
    'key' => 'about',
    'name' => 'О нас',
    'icon' => 'wechat',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Фотогалерея (4 штуки)',
                    'multiple' => true,
                    'type' => 'image',
                    'options' => [
                        'count' => 4,
                        'resize' => [
                            'big' => [
                                'width' => 900,
                                'height' => 900,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'title',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],
                [
                    'header' => 'Партнеры',
                    'key' => 'partners_title',
                    'name' => 'Заголовок',
                    'type' => 'textarea',
                ],
                [
                    'header' => 'Блок плашек',
                    'key' => 'feat_title',
                    'name' => 'Заголовок блока',
                    'type' => 'input',
                ],
                [
                    'key' => 'feat_text_1',
                    'name' => 'Текст 1',
                    'type' => 'input',
                ],
                [
                    'key' => 'feat_text_2',
                    'name' => 'Текст 2',
                    'type' => 'input',
                ],
                [
                    'key' => 'feat_text_3',
                    'name' => 'Текст 3',
                    'type' => 'input',
                ],
                [
                    'header' => 'Блок плашек с иконками',
                    'key' => 'details_title',
                    'name' => 'Заголовок блока',
                    'type' => 'input',
                ],
                [
                    'key' => 'details_text_1',
                    'name' => 'Текст 1',
                    'type' => 'input',
                ],
                [
                    'key' => 'details_text_2',
                    'name' => 'Текст 2',
                    'type' => 'input',
                ],
                [
                    'key' => 'details_text_3',
                    'name' => 'Текст 3',
                    'type' => 'input',
                ],
                [
                    'header' => 'Основатели',
                    'key' => 'head1_img',
                    'name' => 'Фото 1',
                    'multiple' => false,
                    'type' => 'image',
                    'options' => [
                        'count' => 99,
                        'resize' => [
                            'big' => [
                                'width' => 700,
                                'height' => 700,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'head1_name',
                    'name' => 'ФИО 1',
                    'type' => 'input',
                ],
                [
                    'key' => 'head1_post',
                    'name' => 'Должность 1',
                    'type' => 'input',
                ],
                [
                    'header' => 'Основатели',
                    'key' => 'head2_img',
                    'name' => 'Фото 2',
                    'multiple' => false,
                    'type' => 'image',
                    'options' => [
                        'count' => 99,
                        'resize' => [
                            'big' => [
                                'width' => 700,
                                'height' => 700,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'head2_name',
                    'name' => 'ФИО 2',
                    'type' => 'input',
                ],
                [
                    'key' => 'head2_post',
                    'name' => 'Должность 2',
                    'type' => 'input',
                ],
                [
                    'header' => 'Основатели',
                    'key' => 'head3_img',
                    'name' => 'Фото 3',
                    'multiple' => false,
                    'type' => 'image',
                    'options' => [
                        'count' => 99,
                        'resize' => [
                            'big' => [
                                'width' => 700,
                                'height' => 700,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'head3_name',
                    'name' => 'ФИО 3',
                    'type' => 'input',
                ],
                [
                    'key' => 'head3_post',
                    'name' => 'Должность 3',
                    'type' => 'input',
                ],
                [
                    'header' => 'Блок плашек 2',
                    'key' => 'feat_title_2',
                    'name' => 'Заголовок блока',
                    'type' => 'input',
                ],
                [
                    'key' => 'feat_text_2_1',
                    'name' => 'Текст 1',
                    'type' => 'input',
                ],
                [
                    'key' => 'feat_text_2_2',
                    'name' => 'Текст 2',
                    'type' => 'input',
                ],
                [
                    'key' => 'feat_text_2_3',
                    'name' => 'Текст 3',
                    'type' => 'input',
                ],

            ],
        ],
    ],
]; 