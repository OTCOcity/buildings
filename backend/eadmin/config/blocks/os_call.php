<?php
return [
    'key' => 'os_call',
    'name' => 'Звонок',
    'icon' => 'phone',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Фио',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'phone',
                    'name' => 'Контакт',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата',
                    'type' => 'datepicker',
                    'in_list' => true,
                ],
            ],
        ],
    ],
];