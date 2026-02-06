<?php
return [
    'key' => 'catalog_goods',
    'name' => 'Товар',
    'icon' => 'shopping-cart',
    'saveCallback' => '\frontend\components\MiscFunc::updateGroupSize',
    'deleteCallback' => '\frontend\components\MiscFunc::updateGroupSize',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Главное изображение',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'small' => [
                                'width' => 350,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'galary_image',
                    'name' => 'Фотогалерея',
                    'type' => 'image',
                    'multiple' => true,
                    'options' => [
                        'count' => 100,
                        'resize' => [
                            'small' => [
                                'width' => 200,
                                'height' => 200,
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
                    'key' => 'article',
                    'name' => 'Артикул',
                    'type' => 'input',
                    'in_list' => true,
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
                    'key' => 'price',
                    'name' => 'Цена',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'old_price',
                    'name' => 'Старая цена',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'sale',
                    'name' => 'Значок скидки (что будет написано в круглешке)',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'is_cotton',
                    'name' => 'Значок хлопка',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'main_show',
                    'name' => 'Выводить на главной в рекомендациях',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'sex',
                    'name' => 'Пол',
                    'type' => 'select',
                    'data' => [
                        'values' => ['Для мальчиков', 'Для девочек', 'Для мальчиков и девочек']
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'age',
                    'name' => 'Возраст',
                    'type' => 'select',
                    'multiple' => true,
                    'data' => [
                        'values' => [
                            'От 0 до 1 месяцев',
                            'От 1 до 3 месяцев',
                            'От 3 до 6 месяцев',
                            'От 6 до 9 месяцев',
                            'От 9 до 12 месяцев',
                            'От 12 до 18 месяцев',
                            'От 18 до 24 месяцев',
                            'От 24 до 36 месяцев',
                            '4 года',
                            '5 лет',
                            '6 лет',
                            '7 лет',
                            '8 лет',
                            '9-10 лет',
                            '10-12 лет',
                            '12-14 лет',
                            '14-16 лет',
                            '16-18 лет',
                        ]
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'size',
                    'name' => 'Размеры в наличии',
                    'type' => 'select',
                    'in_list' => true,
                    'multiple' => true,
                    'data' => [
                        'values' => [
                            56,
                            68,
                            74,
                            80,
                            86,
                            92,
                            98,
                            104,
                            110,
                            116,
                            122,
                            128,
                            134,
                            140,
                            146,
                            152,
                            158,
                            164
                        ]
                    ],
                ],
                [
                    'key' => 'sale_page',
                    'name' => 'Выводить в разделе акции',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'sale_sort',
                    'name' => 'Порядковый номер в разделе акции',
                    'type' => 'input',
                ],
                [
                    'key' => 'sale_text',
                    'name' => 'Текст для акции',
                    'type' => 'ckeditor',
                ],
//                [
//                    'key' => 'opt_cart',
//                    'name' => 'Можно добавлять в корзину',
//                    'type' => 'checkbox',
//                ],
//                [
//                    'key' => 'benefit',
//                    'name' => 'Блоки с выгодой',
//                    'type' => 'select',
//                    'multiple' => true,
//                    'data' => [
//                        'table' => 'b_benefit',
//                        'name' => 'name',
//                        'value' => 'id',
//                        'where' => '1',
//                    ],
//                ],
                [
                    'key' => 'similar_goods',
                    'name' => 'Сопутствующие товары',
                    'type' => 'select',
                    'multiple' => true,
                    'data' => [
                        'table' => 'b_catalog_goods',
                        'name' => 'name',
                        'value' => 'id',
                        'where' => '1',
                    ],
                ],
                [
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],

//                [
//                    'key' => 'similar_groups',
//                    'name' => 'Сопутствующие группы',
//                    'type' => 'select',
//                    'multiple' => true,
//                    'data' => [
//                        'table' => 'thread',
//                        'name' => 'name',
//                        'value' => 'id',
//                        'where' => ' `module` = 10 AND `lvl` > 1 ',
//                    ],
//                ],

            ],
        ],
//        [
//            'name' => 'Описание',
//            'icon' => 'align-left',
//            'color' => 'blue',
//            'fields' => [
//                [
//                    'key' => 'anons',
//                    'name' => 'Анонс',
//                    'type' => 'ckeditor',
//                ],
//                [
//                    'key' => 'text_before',
//                    'name' => 'Описание до вариантов',
//                    'type' => 'ckeditor',
//                ],
//                [
//                    'key' => 'text_tech',
//                    'name' => 'Технические характеристики (построчно через точку с запятой)',
//                    'type' => 'textarea',
//                    'rows' => 7,
//                ],
//
//            ],
//        ],
//        [
//            'name' => 'Варианты',
//            'icon' => 'paint-brush',
//            'color' => 'green',
//            'count_color' => 'success',
//            'inner_blocks' => 'good_variant',
//        ],
    ],
];