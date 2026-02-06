<?php
return [
    'key' => 'object',
    'name' => 'Объект',
    'icon' => 'building',
//    'saveCallback' => '\frontend\components\MiscFunc::updateGroupSize',
//    'deleteCallback' => '\frontend\components\MiscFunc::updateGroupSize',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'image',
                    'name' => 'Главное изображение',
                    'type' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 600,
                                'height' => 600,
                                'type' => 'bestfit',
                            ],
                            'small' => [
                                'width' => 250,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'gallery_images',
                    'name' => 'Фотогалерея',
                    'type' => 'image',
                    'multiple' => true,
                    'options' => [
                        'count' => 100,
                        'resize' => [
                            'big' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 600,
                                'height' => 600,
                                'type' => 'bestfit',
                            ],
                            'small' => [
                                'width' => 250,
                                'height' => 250,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'name',
                    'name' => 'Название',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true,
                ],
                [
                    'key' => 'address',
                    'name' => 'Адрес',
                    'type' => 'input',
                    'in_list' => true,
                    'lang' => true,
                ],
                [
                    'key' => 'obj_city_id',
                    'name' => 'Город',
                    'type' => 'select',
                    'data' => [
                        'table' => 'obj_city',
                        'name' => 'name',
                        'value' => 'id',
                    ],
                ],
                [
                    'key' => 'obj_district_id',
                    'name' => 'Район',
                    'type' => 'select',
                    'data' => [
                        'table' => 'obj_district',
                        'name' => 'name',
                        'value' => 'id',
                    ],
                ],
                [
                    'key' => 'obj_street_id',
                    'name' => 'Улица',
                    'type' => 'select',
                    'data' => [
                        'table' => 'obj_street',
                        'name' => 'name',
                        'value' => 'id',
                    ],
                ],
                [
                    'key' => 'link',
                    'name' => 'Ссылка',
                    'type' => 'input',
//                    'in_list' => true,
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
                        'data-transliterate-target' => "#structureblock-address",
                    ]
                ],
                [
                    'key' => 'obj_type_id',
                    'name' => 'Тип',
                    'type' => 'select',
                    'data' => [
                        'table' => 'obj_type',
                        'name' => 'name',
                        'value' => 'id',
//                        'where' => "active = 1 AND module = 10",
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'obj_rent_type_id',
                    'name' => 'Тип сделки',
                    'type' => 'select',
                    'data' => [
                        'table' => 'obj_rent_type',
                        'name' => 'name',
                        'value' => 'id',
//                        'where' => "active = 1 AND module = 10",
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'price',
                    'name' => 'Цена',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'about',
                    'name' => 'Описание',
                    'type' => 'input',
//                    'in_list' => true,
                ],
                [
                    'key' => 'obj_room_type_id',
                    'name' => 'Количество комнат',
                    'type' => 'select',
                    'data' => [
                        'table' => 'obj_room_type',
                        'name' => 'name',
                        'value' => 'id',
//                        'where' => "active = 1 AND module = 10",
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'badrooms',
                    'name' => 'Спальных комнат',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'baths',
                    'name' => 'Ванных комнат',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'sq',
                    'name' => 'Площадь',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'floor',
                    'name' => 'Этаж',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'floors',
                    'name' => 'Этажей',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'is_hot',
                    'name' => 'Горячее предложение',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'is_super',
                    'name' => 'Супер предложение',
                    'type' => 'checkbox',
                    'in_list' => true,
                ],
                [
                    'key' => 'options',
                    'name' => 'Характеристики',
                    'type' => 'textarea',
                    'rows' => 10
                ],


                [
                    'key' => 'text',
                    'name' => 'Текст на странице',
                    'type' => 'ckeditor',
                ],
//                [
//                    'key' => 'extra_text',
//                    'name' => 'Детали',
//                    'type' => 'ckeditor',
//                ],

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