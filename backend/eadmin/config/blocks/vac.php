<?php
return [
    'key' => 'vac',
    'name' => 'Вакансия',
    'icon' => 'briefcase',
    'tabs' => [
        [
            'name' => 'Инфо',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Название вакансии',
                    'type' => 'input',
                    'in_list' => true,
                    'validate' => [
                        [
                            'validator' => 'required',
                            'options' => [],
                        ],
                    ],
                ],
                [
                    'key' => 'text_require',
                    'name' => 'Требования',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'text_respons',
                    'name' => 'Обязанности',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'text_conditions',
                    'name' => 'Условия работы',
                    'type' => 'ckeditor',
                ],
                [
                    'key' => 'text_comment',
                    'name' => 'Комментарий',
                    'type' => 'ckeditor',
                ],
            ],
        ],
    ],
];