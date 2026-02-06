<?php
return [
    'key' => 'office',
    'name' => 'Офис',
    'icon' => 'map-marker',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'title',
                    'name' => 'Название',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'name',
                    'name' => 'Адрес',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ],
                ],
                [
                    'key' => 'phone',
                    'name' => 'Телефон',
                    'type' => 'textarea',
                    'in_list' => true,
                ],
                [
                    'key' => 'email',
                    'name' => 'Email',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'work',
                    'name' => 'Часы работы',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'location',
                    'name' => 'Метка на карте',
                    'type' => 'gmap',
                ],
            ],
        ],
    ],
];