<?php
return [
    'key' => 'video',
    'name' => 'Видео',
    'icon' => 'video-camera',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image_poster',
                    'name' => 'Постер',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 300,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'image_awards',
                    'name' => 'Awards',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'multiple' => true,
                    'options' => [
                        'count' => 99,
                        'resize' => [
                            'big' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 300,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'image_selections',
                    'name' => 'Selection',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'multiple' => true,
                    'options' => [
                        'count' => 99,
                        'resize' => [
                            'big' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 300,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'image_screenshots',
                    'name' => 'Screenshots',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'multiple' => true,
                    'options' => [
                        'count' => 99,
                        'resize' => [
                            'big' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 300,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
                    'key' => 'link',
                    'name' => 'Url на сайте',
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
                    'name' => 'Подзаголовок',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'video_url',
                    'name' => 'Ссылка на видео (Vimeo)',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата создания',
                    'is_int' => true,
                    'type' => 'datepicker',
                    'in_list' => true,
                    'value' => time(),
                ],
                [
                    'key' => 'credits',
                    'name' => 'Credits (построчно через двоеточие)',
                    'placeholder' => 'Должность: Фио',
                    'type' => 'textarea',
                    'lang' => true
                ],
                [
                    'key' => 'text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                    'lang' => true
                ],

            ],
        ],
    ],
];