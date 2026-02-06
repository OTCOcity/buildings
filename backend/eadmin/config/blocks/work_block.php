<?php
return [
    'key' => 'work_block',
    'name' => 'Работа',
    'icon' => 'newspaper-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'green',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'medium' => [
                                'width' => 1500,
                                'height' => 900,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'name',
                    'name' => 'Название (нигде не отображается)',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
                    'key' => 'title',
                    'name' => 'Заголовок для отображения',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true
                ],
                [
                    'key' => 'vimeo',
                    'name' => 'Vimeo видео',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'text',
                    'name' => 'Текст под первой картинкой',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
                [
                    'key' => 'text2',
                    'name' => 'Текст под второй картинкой',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
                [
                    'key' => 'type',
                    'name' => 'Позиция текста',
                    'type' => 'select',
                    'data' => [
                        'values' => [
                            'По ширине', 'Справа под картинкой', 'Слева под картинкой', 'Справа от картинки', 'Слева от картинки'
                        ]
                    ],
                ],
            ],

        ],
        [
            'name' => 'Циата',
            'icon' => 'quote-right',
            'color' => 'blue',
            'fields' => [
                [
                    'key' => 'blockquot',
                    'name' => 'Цитата',
                    'type' => 'textarea',
                    'lang' => true
                ],
                [
                    'key' => 'stuff_id',
                    'name' => 'Автор',
                    'type' => 'select',
                    'multiple' => false,
                    'data' => [
                        'table' => 'b_stuff',
                        'name' => 'name',
                        'value' => 'id',
                        'where' => '1',
                    ],
                ],

            ],
        ],
        [
            'name' => 'Табы',
            'icon' => 'th-large',
            'color' => 'red',
            'fields' => [
                [
                    'key' => 'tab_one_name',
                    'header' => 'Таб #1',
                    'name' => 'Название',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'tab_one_text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
                [
                    'key' => 'tab_two_name',
                    'header' => 'Таб #2',
                    'name' => 'Название',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'tab_two_text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
                [
                    'key' => 'tab_three_name',
                    'header' => 'Таб #3',
                    'name' => 'Название',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'tab_three_text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                    'lang' => true
                ],
                [
                    'key' => 'tab_four_name',
                    'header' => 'Таб #4',
                    'name' => 'Название',
                    'type' => 'input',
                    'lang' => true
                ],
                [
                    'key' => 'tab_four_text',
                    'name' => 'Текст',
                    'type' => 'ckeditor',
                    'lang' => true
                ],

            ],
        ],
    ],
];