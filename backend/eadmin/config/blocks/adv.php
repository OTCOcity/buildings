<?php
return [
    'key' => 'adv',
    'name' => 'Реклама',
    'icon' => 'child',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'child',
            'color' => 'blue',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Изображение',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Наименование',
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
                    'in_list' => true,
                ],
                [
                    'key' => 'blank',
                    'name' => 'Открывать в новой вкладке',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'html',
                    'name' => 'Html код',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'groups',
                    'name' => 'Привязать к группам',
                    'type' => 'select',
                    'multiple' => true,
                    'data' => [
                        'table' => 'thread',
                        'name' => 'name',
                        'value' => 'id',
                        'where' => "active = 1 AND module = 10",
                    ],
                ],
                [
                    'key' => 'goods',
                    'name' => 'Привязать к товарам',
                    'type' => 'select',
                    'multiple' => true,
                    'data' => [
                        'table' => 'b_catalog_goods',
                        'name' => 'name',
                        'value' => 'id',
                        'where' => "visible = 1",
                    ],
                ],
                [
                    'key' => 'desktop',
                    'name' => 'Располагать над навигацией (отображается только на десктопной версии)',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
            ],
        ],
    ],
];