<?php
return [
    'key' => 'seo_filter',
    'name' => 'SEO фильтры',
    'icon' => 'filter',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Фон',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'small' => [
                                'width' => 400,
                                'height' => 350,
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
                    'key' => 'url_from',
                    'name' => 'Url исходный',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'url_to',
                    'name' => 'Url финальный',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'description',
                    'name' => 'Meta description',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
                    'key' => 'keywords',
                    'name' => 'Meta keywords',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
                    'key' => 'is_main',
                    'name' => 'Выводить на главной',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                    'in_list' => true,
                    'lang' => true
                ],

            ],
        ],
    ],
];