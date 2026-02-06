<?php
return [
    'key' => 'object',
    'name' => 'Объекты',
    'icon' => 'home',
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
            ]
        ],
    ]
];