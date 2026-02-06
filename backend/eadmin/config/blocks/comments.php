<?php
return [
    'key' => 'comments',
    'name' => 'Комментырии',
    'icon' => 'comments-o',
    'tabs' => [
        [
            'name' => 'Комментарий',
            'icon' => 'comments-o',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Автор',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'user_id',
                    'name' => 'Профиль пользователя',
                    'type' => 'select',
                    'in_list' => true,
                    'data' => [
                        'table' => 'b_clients',
                        'name' => "CONCAT(email, ' (', sirname, ' ', name, ' ', midname, ')')",
                        'value' => 'id',
                        'where' => 1,
                    ],

                ],
                [
                    'key' => 'date',
                    'name' => 'Дата',
                    'type' => 'datepicker',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
                [
                    'key' => 'text',
                    'name' => 'Текст комментария',
                    'type' => 'ckeditor',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
               ],
                [
                    'key' => 'rating',
                    'name' => 'Рейтинг',
                    'type' => 'select',
                    'in_list' => true,
                    'data' => [
                        'values' => [0,1,2,3,4],
                    ]
                ],
            ],
        ],
    ],
];