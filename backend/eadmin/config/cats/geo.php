<?php
return [
    'key' => 'geo',
    'name' => 'География работ',
    'icon' => 'map-marker',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'font',
            'color' => 'blue',
            'count_color' => 'success',
            'fields' => [
                [
                    'key' => 'text',
                    'name' => 'Текст под регионами',
                    'type' => 'ckeditor',
                ],
			],
        ],
        [
            'name' => 'Города',
            'icon' => 'globe',
            'color' => 'green',
            'count_color' => 'success',
            'inner_blocks' => 'geo_cities',
        ],

    ],
];