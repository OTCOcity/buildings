<?php
return [
    'key' => 'geo_cities',
    'name' => 'Город',
    'icon' => 'globe',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'globe',
            'color' => 'blue',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Наименование',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
                [
                    'key' => 'location',
                    'name' => 'Расположение',
                    'type' => 'gmap',
                ],
                [
                    'key' => 'region',
                    'name' => 'Это регион',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
            ],
        ],
        [
            'name' => 'Элементы',
            'icon' => 'bookmark-o',
            'color' => 'green',
            'count_color' => 'success',
            'inner_blocks' => 'geo_item',
        ],

    ],
];