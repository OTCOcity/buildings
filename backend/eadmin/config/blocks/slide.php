<?php
return [
    'key' => 'slide',
    'name' => 'Слайд',
    'icon' => 'newspaper-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 1000,
                                'height' => 700,
                                'type' => 'bestfit',
                            ],
                        ]
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Надпись',
                    'type' => 'ckeditor',
                    'in_list' => true,
                ],
//                [
//                    'key' => 'link',
//                    'name' => 'Ссылка',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
            ],
        ],
    ],
];