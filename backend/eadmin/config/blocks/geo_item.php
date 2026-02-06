<?php
return [
    'key' => 'geo_item',
    'name' => 'Элемент',
    'icon' => 'bookmark-o',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'blue',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображения',
                    'type' => 'image',
                    'options' => [
                        'count' => 100,
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
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'url',
                    'name' => 'Ссылка на раздел',
                    'type' => 'input',
                ],
            ],
        ],
    ],
];