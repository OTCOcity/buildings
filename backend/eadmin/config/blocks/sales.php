<?php
return [
    'key' => 'sales',
    'name' => 'Акции',
    'icon' => 'bookmark-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображениe',
                    'type' => 'image',
                    'in_list' => true,
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'small' => [
                                'width' => 400,
                                'height' => 200,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Имя',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ]
                ],
                [
                    'key' => 'link',
                    'name' => 'Ссылка',
                    'type' => 'input',
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                        [
                            'validator' => 'match',
                            'options' => [
                                'pattern' => '/^[a-z0-9\-_]*$/i',
                                'message' => "Недопустимые символы в ссылке"
                            ],
                        ],
                    ],
                    'html_attrs' => [
                        'data-transliterate-target' => "#structureblock-name",
                    ]
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата проведения',
                    'type' => 'datepicker',
                    'value' => time(),
                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
                ],
                [
                    'key' => 'date_start',
                    'name' => 'Дата начала акции',
                    'type' => 'datepicker',
                    'value' => time(),
                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
                ],
                [
                    'key' => 'date_finish',
                    'name' => 'Дата окончания акции',
                    'type' => 'datepicker',
                    'value' => time(),
                    'in_list' => true,
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                    ]
                ],
                [
                    'key' => 'anons',
                    'name' => 'Анонс акции',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'text',
                    'name' => 'Описание акции',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'url',
                    'name' => 'Ссылка на раздел каталога',
                    'type' => 'input',
                ],
                [
                    'key' => 'filter_list',
                    'name' => 'Относится к разделам (для фильтрации в спецпредложениях)',
                    'type' => 'select',
                    'multiple' => true,
                    'data' => [
                        'table' => 'thread',
                        'name' => 'name',
                        'value' => 'id',
                        'where' => ' `module` = 10 AND `active` = 1 AND `parent` = 48 ',
                    ],
                ],

                [
                    'key' => 'group_list',
                    'name' => 'Выводить на страницах групп',
                    'type' => 'select',
                    'multiple' => 'multiple',
                    'data' => [
                        'table' => 'thread',
                        'name' => 'name',
                        'value' => 'id',
                        'where' => 'module = 10',
                    ],
                ],

                [
                    'key' => 'good_list',
                    'name' => 'Выводить на страницах товров',
                    'type' => 'select',
                    'multiple' => 'multiple',
                    'data' => [
                        'table' => 'b_catalog_goods',
                        'name' => 'name',
                        'value' => 'id',
                    ],
                ],

            ],
        ],
    ],
];