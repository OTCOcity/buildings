<?php
return [
    'key' => 'object_prop',
    'name' => 'Свойства',
    'icon' => 'filter',
//    'saveCallback' => '\frontend\components\MiscFunc::updateGroupSize',
//    'deleteCallback' => '\frontend\components\MiscFunc::updateGroupSize',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Название (колонка в excel файле)',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'key',
                    'name' => 'Свойство',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
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
                    'key' => 'is_listed',
                    'name' => 'Выводить как доп свойство',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],

            ],
        ],

//        [
//            'name' => 'Варианты',
//            'icon' => 'paint-brush',
//            'color' => 'green',
//            'count_color' => 'success',
//            'inner_blocks' => 'good_variant',
//        ],
    ],
];