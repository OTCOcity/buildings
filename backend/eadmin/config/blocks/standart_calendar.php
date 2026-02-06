<?php
return [
    'key' => 'standart_calendar',
    'name' => 'Календарь работ',
    'icon' => 'calendar',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Название',
                    'in_list' => true,
                    'type' => 'input',
                ],
                [
                    'header' => 'Период 1',
                    'key' => 'date_from',
                    'name' => 'Месяц начала',
                    'in_list' => true,
                    'is_int' => true,
                    'type' => 'datepicker',
                ],
                [
                    'key' => 'date_to',
                    'name' => 'Месяц окончания',
                    'in_list' => true,
                    'is_int' => true,
                    'type' => 'datepicker',
                ],
                [
                    'header' => 'Период 2',
                    'key' => 'date_from_2',
                    'name' => 'Месяц начала 2',
                    'in_list' => true,
                    'is_int' => true,
                    'type' => 'datepicker',
                ],
                [
                    'key' => 'date_to_2',
                    'name' => 'Месяц окончания 2',
                    'in_list' => true,
                    'is_int' => true,
                    'type' => 'datepicker',
                ],
                [
                    'key' => 'color',
                    'name' => 'Цвет',
                    'in_list' => true,
                    'type' => 'colorpicker',
                ],
            ],
        ],
    ],
];