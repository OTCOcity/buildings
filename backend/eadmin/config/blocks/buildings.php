<?php
return [
    'key' => 'buildings',
    'name' => 'Блоки недвижимости',
    'icon' => 'building-o',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Адрес',
                    'type' => 'input',
                    'in_list' => true,
                ],
                [
                    'key' => 'link',
                    'name' => 'Ссылка',
                    'type' => 'input',
                    'validate' => [
                        [
                            'validator' => 'match',
                            'options' => [
                                'pattern' => '/^[a-z0-9\-_]*$/i',
                                'message' => 'Недопустимые символы в ссылке',
                            ],
                        ],
                    ],
                    'html_attrs' => [
                        'data-transliterate-target' => '#structureblock-name',
                    ],
                ],
                [
                    'key' => 'mortgage_size',
                    'name' => 'Размер ипотеки',
                    'type' => 'input',
                ],
                [
                    'key' => 'payment_amount',
                    'name' => 'Сумма платежа',
                    'type' => 'input',
                ],
                [
                    'key' => 'purchase_date',
                    'name' => 'Дата покупки',
                    'type' => 'datepicker',
                    'value' => time(),
                ],
                [
                    'key' => 'payment_date',
                    'name' => 'Дата платежа',
                    'type' => 'datepicker',
                    'value' => time(),
                ],
                [
                    'key' => 'next_insurance_date',
                    'name' => 'Дата следующей страховки',
                    'type' => 'datepicker',
                    'value' => time(),
                ],
                [
                    'key' => 'position',
                    'name' => 'Координаты здания',
                    'type' => 'gmap',
                ],
                [
                    'key' => 'files',
                    'name' => 'Файлы',
                    'type' => 'file',
                ],
                [
                    'key' => 'description',
                    'name' => 'Описание',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'history',
                    'name' => 'История',
                    'type' => 'ckeditor',
                ],
            ],
        ],
    ],
];
