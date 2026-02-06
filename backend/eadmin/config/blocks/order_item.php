<?php
return [
    'key' => 'order_item',
    'name' => 'Позиция в заказе',
    'icon' => 'reorder',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'good_id',
                    'name' => 'ID товара',
                    'type' => 'input',
                ],
                [
                    'key' => 'variant_id',
                    'name' => 'ID варианта',
                    'type' => 'input',
                ],
                [
                    'key' => 'name',
                    'name' => 'Наименование товара',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'subname',
                    'name' => 'Характеристики',
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
                    'key' => 'count',
                    'name' => 'Количество',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'sum',
                    'name' => 'Сумма',
                    'type' => 'input',
                    'in_list' => true,
                ],
            ]
        ],
    ],
];