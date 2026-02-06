<?php
return [
    'key' => 'portfolio',
    'name' => 'Портфолио',
    'icon' => 'paint-brush',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
//                [
//                    'key' => 'image',
//                    'name' => 'Изображениe',
//                    'type' => 'image',
//                    'options' => [
//                        'count' => 1,
//                        'resize' => [
//                            'big' => [
//                                'width' => 800,
//                                'height' => 600,
//                                'type' => 'bestfit',
//                            ],
//                            'small' => [
//                                'width' => 320,
//                                'height' => 240,
//                                'type' => 'bestfit',
//                            ],
//                        ],
//                    ],
//                ],
                [
                    'key' => 'name',
                    'name' => 'Название',
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
                    'key' => 'link',
                    'name' => 'Ссылка',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
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
                    'name' => 'Краткий анонс',
                    'type' => 'textarea',
                    'in_list' => true,
                    'rows' => '3',
                ],

                [
                    'key' => 'text',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],


            ],
        ],
    ],
];