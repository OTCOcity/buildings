<?php
return [
    'key' => 'news',
    'name' => 'Новости',
    'icon' => 'newspaper-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'main_image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 700,
                                'height' => 700,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
//                [
//                    'key' => 'link',
//                    'name' => 'Ссылка',
//                    'type' => 'input',
//                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'match',
//                            'options' => [
//                                'pattern' => '/^[a-z0-9\-_]*$/i',
//                                'message' => "Недопустимые символы в ссылке"
//                            ],
//                        ],
//                    ],
//                    'html_attrs' => [
//                        'data-transliterate-target' => "#structureblock-name",
//                    ]
//                ],
//                [
//                    'key' => 'group',
//                    'name' => 'Раздел',
//                    'type' => 'input',
//                    'in_list' => true,
//                    'lang' => true
//                ],
//                [
//                    'key' => 'date',
//                    'name' => 'Дата создания',
//                    'type' => 'datepicker',
//                    'value' => time(),
//                    'is_int' => true,
//                    'in_list' => true,
//                ],
                [
                    'key' => 'anons',
                    'name' => 'Ссылка на telegram',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
//                [
//                    'key' => 'text',
//                    'name' => 'Текст новости',
//                    'type' => 'ckeditor',
//                    'lang' => true
//                ],

            ],
        ],
    ],
];