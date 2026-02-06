<?php
return [
    'key' => 'palitra',
    'name' => 'Палитра',
    'icon' => 'paint-brush',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'type' => 'input',
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
                [
                    'key' => 'text',
                    'name' => 'Текстовое описание',
                    'type' => 'ckeditor',
                ],
            ],
        ],       [
            'name' => 'Цвета',
            'icon' => 'paint-brush',
            'color' => 'green',
            'count_color' => 'success',
            'inner_blocks' => 'colors',
        ],
    ],
];