<?php
return [
    'key' => 'catalog_group',
    'name' => 'Группа товаров',
    'icon' => 'database',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
//                [
//                    'key' => 'image',
//                    'name' => 'Изображение',
//                    'type' => 'image',
//                    'options' => [
//                        'count' => 1,
//                        'resize' => [
//                            'medium' => [
//                                'width' => 350,
//                                'height' => 250,
//                                'type' => 'bestfit',
//                            ],
//                            'small' => [
//                                'width' => 60,
//                                'height' => 60,
//                                'type' => 'bestfit',
//                            ],
//                        ],
//                    ],
//                ],
//                [
//                    'key' => 'anons',
//                    'name' => 'Анонс',
//                    'type' => 'textarea',
//                ],
                [
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],

            ],
        ],
        [
            'name' => 'Товары',
            'icon' => 'shopping-cart',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'catalog_goods',
        ],
    ],
];