<?php
return [
    'key' => 'standart',
    'name' => 'Стандарт',
    'icon' => 'file-text-o',
    'tabs' => [
        [
            'name' => 'Общая информация',
            'icon' => 'info',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'file',
                    'name' => 'Обложка',
                    'type' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Название стандарта',
                    'in_list' => true,
                    'type' => 'input',
                ], [
                    'key' => 'link',
                    'name' => 'Ссылка',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'match',
                            'options' => [
                                'pattern' => '/^[a-z0-9\-_]*$/i',
                                'message' => "Недопустимые символы в ссылке"
                            ],
                        ],
                    ],
                    'html_attrs' => [
                        'data-transliterate-target' => "#structureblock-name",
                    ]
                ],
                [
                    'key' => 'group',
                    'name' => 'Группа стандарта',
                    'type' => 'input',
                    'in_list' => true,
                ],
//                [
//                    'key' => 'file',
//                    'name' => 'Файл стандарта для скачивания',
//                    'type' => 'file',
//                    'in_list' => true,
//                    'options' => [
//                        'count' => 1,
//                    ],
//                ],
                [
                    'key' => 'date',
                    'name' => 'Дата обновления',
                    'type' => 'datepicker',
                    'is_int' => true, // Как хранится дата - как строка или как число секундs
                    'value' => time(),
                    'in_list' => true,
                ],
            ],
        ],
        [
            'name' => 'Разделы стандарта',
            'icon' => 'file-text-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'sub_standart',
        ],
        [
            'name' => 'Календарь работ',
            'icon' => 'calendar',
            'color' => 'green',
            'count_color' => 'success',
            'inner_blocks' => 'standart_calendar',
        ],
        [
            'name' => 'Блок заказа',
            'icon' => 'credit-card',
            'color' => 'red',
            'fields' => [
                [
                    'key' => 'buy_image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 400,
                                'height' => 400,
                                'type' => 'bestfit',
                            ],
                        ],

                    ],
                ],
                [
                    'key' => 'buy_title',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'buy_anons',
                    'name' => 'Краткое описание',
                    'type' => 'textarea',
                ],
            ],
        ],

        [
            'name' => 'Чек лист',
            'icon' => 'check-circle-o',
            'color' => 'blue',
            'fields' => [
                [
                    'key' => 'check_text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                ],
            ],
        ],
    ],
];