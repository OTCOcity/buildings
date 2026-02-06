<?php
return [
    'key' => 'stuff',
    'name' => 'Персона',
    'icon' => 'user',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'in_list' => true,
                    'name' => 'Фото',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'small' => [
                                'width' => 150,
                                'height' => 150,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'in_list' => true,
                    'name' => 'Фио',
                    'type' => 'input',
                ],

//                [
//                    'key' => 'email',
//                    'name' => 'E-mail',
//                    'type' => 'input',
//                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'email',
//                            'options' => [],
//                        ],
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
//                ],
//                [
//                    'key' => 'active',
//                    'name' => 'Активен',
//                    'type' => 'checkbox',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'type',
//                    'name' => 'Тип',
//                    'type' => 'select',
//                    'in_list' => true,
//                    'data' => [
//                        'values' => [
//                            0 => "Физ. лицо",
//                            1 => "Юр. лицо",
//                        ],
//                    ],
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ],
//                ],
//                [
//                    'key' => 'sirname',
//                    'name' => 'Фамилия',
//                    'type' => 'input',
//                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
//                ],
//                [
//                    'key' => 'name',
//                    'name' => 'Имя',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'midname',
//                    'name' => 'Отчество',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'phone',
//                    'name' => 'Телефон',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'password',
//                    'name' => 'Новый пароль',
//                    'type' => 'password',
//                ],
//                [
//                    'key' => 'dogovor',
//                    'name' => 'Действует договор',
//                    'type' => 'checkbox',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'file_dog',
//                    'name' => 'Договор',
//                    'type' => 'file',
//                    'multiple' => false,
//                ],
//                [
//                    'key' => 'file_rek',
//                    'name' => 'Файл с реквизитами',
//                    'type' => 'file',
//                    'multiple' => false,
//                    'header' => 'Реквизиты',
//                ],
//                [
//                    'key' => 'company',
//                    'name' => 'Компания',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'ur_adres',
//                    'name' => 'Юридический адрес',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'sob',
//                    'name' => 'Форма собственности',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'ogrn',
//                    'name' => 'ОГРН',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'kpp',
//                    'name' => 'КПП',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'inn',
//                    'name' => 'ИНН',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'bik',
//                    'name' => 'БИК',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rs',
//                    'name' => 'РС',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'ks',
//                    'name' => 'КС',
//                    'type' => 'input',
//                ],

            ],
        ],
//        [
//            'name' => 'Заказы',
//            'icon' => 'shopping-cart',
//            'color' => 'orange',
//            'count_color' => 'warning',
//            'inner_blocks' => 'order',
//        ],
    ],
];