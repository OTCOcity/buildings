<?php
return [
    'key' => 'city',
    'name' => 'Цвет',
    'icon' => 'globe',
    'tabs' => [
        [
            'name' => 'Список городов',
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
                    'key' => 'fullName',
                    'name' => 'Полное наименование',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'code',
                    'name' => 'Код (Деловые линии)',
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
                    'key' => 'country',
                    'name' => 'Страна',
                    'type' => 'select',
                    'in_list' => true,
                    'data' => [
                        'values' => [
                            'ru', 'kz'
                        ]
                    ],
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
            ],
        ],
    ],
];