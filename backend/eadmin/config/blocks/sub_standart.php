<?php
return [
    'key' => 'sub_standart',
    'name' => 'Раздел стандарта',
    'icon' => 'file-text-o',
    'tabs' => [
        [
            'name' => 'Описание',
            'icon' => 'info',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 450,
                                'height' => 600,
                                'type' => 'bestfit',
                            ],
                        ],

                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Заголовок раздела',
                    'in_list' => true,
                    'type' => 'input',
                ],
                [
                    'key' => 'worth',
                    'name' => 'Ключевая ценность',
                    'type' => 'textarea',
                    'in_list' => true,
                ],
                [
                    'key' => 'text',
                    'name' => 'Описание раздела',
                    'type' => 'ckeditor',
                ],
            ],
        ],
        [
            'name' => 'Тех. карта',
            'icon' => 'file-text-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'standart_tech',
        ],
        [
            'name' => 'Спецификация',
            'icon' => 'file-text',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'spec_title',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'spec_text',
                    'name' => 'Текст блока',
                    'type' => 'ckeditor',
                ],
            ],
        ],
        [
            'name' => 'Расход материала',
            'icon' => 'arrow-circle-right',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'exp_text',
                    'name' => 'Текст блока',
                    'type' => 'ckeditor',
                ],
            ],
        ],
        [
            'name' => 'Доп. чертежи',
            'icon' => 'file-text-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'standart_extra_schema',
        ],


    ],
];