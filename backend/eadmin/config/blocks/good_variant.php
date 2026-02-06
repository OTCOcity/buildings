<?php
return [
    'key' => 'good_variant',
    'name' => 'Вариант',
    'icon' => 'paint-brush',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Наименование',
                    'type' => 'input',
                    'in_list' => true,
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
                    'name' => 'Значок скидки',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
            ],
        ],
    ],
];