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
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'multiple' => false,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 2000,
                                'height' => 1100,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
//                [
//                    'key' => 'title',
//                    'name' => 'Заголовок',
//                    'type' => 'input',
//                    'lang' => true
//                ],
                [
                    'key' => 'subtitle',
                    'name' => 'Надпись над заголовком',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'name',
                    'name' => 'Заголовок',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'color',
                    'name' => 'Цвет заголовка',
                    'type' => 'select',
                    'data' => [
                        'values' => ['Черный', 'Белый']
                    ],
                ],
                [
                    'key' => 'vimeo',
                    'name' => 'Видео vimeo (в поле "Текст на странице" вставить код %video% в место куда его нужно разместить)',
                    'type' => 'input',
                ],
                [
                    'key' => 'text',
                    'name' => 'Текст на странице',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
                [
                    'key' => 'text_pos',
                    'name' => 'Позиция текста',
                    'type' => 'select',
                    'data' => [
                        'values' => [
                            'По ширине', 'Справа', 'Слева'
                        ]
                    ],
//                    'lang' => true
                ],
            ],
        ],
//        [
//            'name' => 'Stuff',
//            'icon' => 'user',
//            'color' => 'blue',
//            'count_color' => 'primary',
//            'inner_blocks' => 'manager',
//        ],

    ],
];