<?php
return [
    'key' => 'price',
    'name' => 'Прайс',
    'icon' => 'money',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'group',
                    'name' => 'Группа',
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
                    'key' => 'subgroup',
                    'name' => 'Подгруппа',
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
                    'key' => 'name',
                    'name' => 'Название',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'anons',
                    'name' => 'Краткое описание',
                    'type' => 'input',
                ],
                [
                    'key' => 'text',
                    'name' => 'Полное описание',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'ras',
                    'name' => 'Расход',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'price',
                    'name' => 'Тара и цена (построчно, разделитель «;»)',
                    'type' => 'textarea',
                    'rows' => 4,
                ],

            ],
        ],
    ],
];