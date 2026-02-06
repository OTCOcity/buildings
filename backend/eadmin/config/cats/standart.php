<?php
return [
    'key' => 'standart',
    'name' => 'Стандарты',
    'icon' => 'book',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'pr_image',
                    'name' => 'Изображениe для плашки',
                    'header' => 'Для плашки на главной',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'small' => [
                                'width' => 500,
                                'height' => 350,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'pr_title',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'pr_about',
                    'name' => 'Подстрочник',
                    'type' => 'textarea',
                ],
            ],
        ],
        [
            'name' => 'Стандарты',
            'icon' => 'file-text-o',
            'color' => 'green',
            'count_color' => 'success',
            'inner_blocks' => 'standart',
        ],
    ],
];