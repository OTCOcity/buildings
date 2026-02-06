<?php
return [
    'key' => 'statics',
    'name' => 'Текстовые страницы',
    'icon' => 'font',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'file',
                    'name' => 'Файл для загрузки',
                    'header' => 'Файл для загрузки',
                    'type' => 'file',
                    'options' => [
                        'count' => 2,
                    ],
                    //                    'lang' => true
                ],
                [
                    'key' => 'pr_image',
                    'name' => 'Изображениe для плашки',
                    'header' => 'Для плашки на главной',
                    'type' => 'image',
                    'options' => [
                        'count' => 2,
                        'resize' => [
                            'small' => [
                                'width' => 500,
                                'height' => 350,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                    //                    'lang' => true
                ],
                [
                    'key' => 'color',
                    'name' => 'Цвет',
                    'type' => 'colorpicker',
//                    'lang' => true
                ],
                [
                    'key' => 'location',
                    'name' => 'Карта',
                    'type' => 'gmap',
//                    'lang' => true
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата',
                    'type' => 'datepicker',
//                    'lang' => true
                ],
                [
                    'key' => 'checkbox',
                    'name' => 'Чекбокс',
                    'type' => 'checkbox',
//                    'lang' => true
                ],
                [
                    'key' => 'pr_title',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'anons',
                    'name' => 'Селект',
                    'type' => 'select',
                    'multiple' => true,
                    'data' => [
                        'values' => [
                            'ru', 'en', 'tr'
                        ]
                    ],
//                    'lang' => true
                ],
                [
                    'key' => 'pr_about',
                    'name' => 'Подстрочник',
                    'type' => 'textarea',
//                    'lang' => true
                ],
                [
                    'key' => 'text',
                    'header' => 'Текст на странице',
                    'name' => '',
                    'type' => 'ckeditor',
//                    'lang' => true
                ],
            ],
        ],
    ],
];