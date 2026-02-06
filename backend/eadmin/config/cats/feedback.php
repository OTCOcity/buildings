<?php
return [
    'key' => 'feedback',
    'name' => 'Отзывы',
    'icon' => 'envelope-o',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'text',
                    'name' => 'Текст на странице',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
            ],
        ],
        [
            'name' => 'Отзывы',
            'icon' => 'envelope-o',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'feedback',
        ],
    ],
];