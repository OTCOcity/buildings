<?php
return [
    'key' => 'site_user',
    'name' => 'Пользователь',
    'icon' => 'user',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'child',
            'color' => 'blue',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Логин',
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
                    'key' => 'password',
                    'name' => 'Пароль',
                    'type' => 'input',
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
                [
                    'key' => 'email',
                    'name' => 'E-mail',
                    'type' => 'input',
                    'in_list' => true,
                ],

            ],
        ],
    ],
];