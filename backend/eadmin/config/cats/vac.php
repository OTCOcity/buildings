<?php
return [
    'key' => 'vac',
    'name' => 'Вакансии',
    'icon' => 'briefcase',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'text',
                    'name' => 'Текстовое описание',
                    'type' => 'ckeditor',
                ],
            ],
        ],
        [
            'name' => 'Вакансии',
            'icon' => 'briefcase',
            'color' => 'blue',
            'count_color' => 'primary',
            'inner_blocks' => 'vac',
        ],
    ],
];