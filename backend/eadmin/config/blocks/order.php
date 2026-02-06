<?php
return [
    'key' => 'order',
    'name' => 'Заказ',
    'icon' => 'shopping-cart',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Номер заказа',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата заказа',
                    'type' => 'datepicker',
                    'in_list' => true,
                ],
//                [
//                    'key' => 'client_name',
//                    'name' => 'Фио заказчика',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'client_phone',
//                    'name' => 'Телефон заказчика',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'client_email',
//                    'name' => 'Email заказчика',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'deliv_type',
//                    'name' => 'Тип доставки',
//                    'type' => 'select',
//                    'data' => [
//                        'table' => 'data_deliv_type',
//                        'name' => 'name',
//                        'value' => 'id',
//                        'where' => '1',
//                    ],
//                ],
//                [
//                    'key' => 'deliv_adres',
//                    'name' => 'Адрес',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'deliv_city',
//                    'name' => 'Город',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'deliv_sum',
//                    'name' => 'Стоимость доставки',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'sum_order',
//                    'name' => 'Стоимость заказа',
//                    'type' => 'input',
//                ],
                [
                    'key' => 'text',
                    'name' => 'Номер заказа в Банке',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'sum_itog',
                    'name' => 'Полная стоимость',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'comment',
                    'name' => 'Проверка состояния оплаты',
                    'type' => 'textarea',
                    'in_list' => true,
                ],
                [
                    'key' => 'session',
                    'name' => 'Статус оплаты',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'order',
                    'name' => 'Заказ',
                    'type' => 'ckeditor',
                ],
            ]
        ],
//        [
//            'name' => 'Позиции заказа',
//            'icon' => 'reorder',
//            'color' => 'blue',
//            'count_color' => 'primary',
//            'inner_blocks' => 'order_item',
//        ],
    ],
];