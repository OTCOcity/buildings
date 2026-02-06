<?php
return [
    'key' => 'phones',
    'name' => 'Контакты',
    'icon' => 'phone',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Название',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'phone',
                    'name' => 'Тлефон',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'email',
                    'name' => 'Email',
                    'type' => 'input',
                    'in_list' => true,
                ],
            ],
        ],
    ],
];