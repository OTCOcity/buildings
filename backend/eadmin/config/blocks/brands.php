<?php
return [
    'key' => 'brands',
    'name' => 'Бренды',
    'icon' => 'star-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Логотип',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'small' => [
                                'width' => 200,
                                'height' => 100,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Название бренда',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ],
                ],
                [
                    'key' => 'url',
                    'name' => 'Ссылка на сайт',
                    'type' => 'input',
                ],
            ],
        ],
    ],
];