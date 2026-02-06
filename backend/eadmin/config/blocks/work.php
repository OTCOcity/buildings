<?php
return [
    'key' => 'work',
    'name' => 'Работа',
    'icon' => 'newspaper-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 900,
                                'height' => 900,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                    'in_list' => true,
                ],
//                [
//                    'key' => 'view_image',
//                    'name' => 'Выводить картинку в шапке работы',
//                    'type' => 'checkbox',
//                ],
//                [
//                    'key' => 'color',
//                    'name' => 'Цвет заголовка',
//                    'type' => 'select',
//                    'data' => [
//                        'values' => ['Черный', 'Белый']
//                    ],
//                ],
//                [
//                    'key' => 'format',
//                    'name' => 'Формат фото',
//                    'type' => 'select',
//                    'data' => [
//                        'values' => ['Горизонтальное', 'Вертикальное']
//                    ],
//                ],
                [
                    'key' => 'name',
                    'name' => 'Название',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
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
                    'name' => 'Раздел',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата создания',
                    'type' => 'datepicker',
                    'value' => time(),
                    'is_int' => true,
                    'in_list' => true,
                ],
                [
                    'key' => 'buy_link',
                    'name' => 'Цена',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'shine_color',
                    'name' => 'Цвет сияния',
                    'type' => 'colorpicker',
                    'in_list' => true,
                ],
                [
                    'key' => 'shine_pos',
                    'name' => 'Цвет сияния',
                    'in_list' => true,
                    'type' => 'select',
                    'data' => [
                        'values' => ['Слева', 'Спарва', 'Снизу']
                    ],
                ],
            ],
        ],
        [
            'name' => 'Таблица',
            'icon' => 'table',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 't_active',
                    'name' => 'Вывести таблицу',
                    'type' => 'checkbox',
                ],
                [
                    'key' => 't_name',
                    'name' => 'Название',
                    'type' => 'input',
                ],
//                [
//                    'key' => 't_type',
//                    'name' => 'Тип',
//                    'type' => 'input',
//                ],
                [
                    'key' => 't_date',
                    'name' => 'Дата',
                    'type' => 'input',
                ],
                [
                    'key' => 't_author',
                    'name' => 'Автор',
                    'type' => 'input',
                ],
                [
                    'key' => 't_loc',
                    'name' => 'Локация',
                    'type' => 'input',
                ],
//                [
//                    'key' => 't_client',
//                    'name' => 'Клиент',
//                    'type' => 'input',
//                ],
                [
                    'key' => 't_place',
                    'name' => 'Площадка',
                    'type' => 'input',
                ],
                [
                    'key' => 't_r_days',
                    'name' => 'Разработано',
                    'type' => 'input',
                ],
                [
                    'key' => 't_p_days',
                    'name' => 'Произведено',
                    'type' => 'input',
                ],
                [
                    'key' => 't_m_days',
                    'name' => 'Смонтировано',
                    'type' => 'input',
                ],
                [
                    'key' => 't_team',
                    'name' => 'Команда, построчно (Должность, ФИО...)',
                    'type' => 'textarea',
                ],
            ],
        ],
        [
            'name' => 'Наполнение',
            'icon' => 'newspaper-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'work_block',
        ],
    ],
];