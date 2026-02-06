<?php
return [
    'key' => 'services',
    'name' => 'Услуги',
    'icon' => 'newspaper-o',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображениe',
                    'type' => 'image',
                    'in_list' => true,
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
                    'name' => 'Наименование',
                    'in_list' => true,
                    'type' => 'input',
                ],
                [
                    'key' => 'link',
                    'name' => 'Ссылка',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'match',
                            'options' => [
                                'pattern' => '/^[a-z0-9\-_]*$/i',
                                'message' => "Недопустимые символы в ссылке"
                            ],
                        ],
                    ],
                    'html_attrs' => [
                        'data-transliterate-target' => "#structureblock-name",
                    ]
                ],
                [
                    'key' => 'anons',
                    'name' => 'Краткое описание',
                    'in_list' => true,
                    'type' => 'textarea',
                ],
                [
                    'key' => 'text',
                    'header' => 'Текст на странице',
                    'name' => 'Текстовое описание',
                    'type' => 'ckeditor',
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