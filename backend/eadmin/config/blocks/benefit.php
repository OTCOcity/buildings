<?php
return [
    'key' => 'benefit',
    'name' => 'Выгода',
    'icon' => 'thumbs-o-up',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
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
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                    'in_list' => true,
                ],
            ],
        ],
    ],
];