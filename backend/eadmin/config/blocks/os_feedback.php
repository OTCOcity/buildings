<?php
return [
    'key' => 'os_feedback',
    'name' => 'Письмо',
    'icon' => 'phone',
    'sort' => 'date desc',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'name',
                    'name' => 'Фио',
                    'type' => 'input',
                    'in_list' => true,
                ],
//                [
//                    'key' => 'theme',
//                    'name' => 'Тема',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
                [
                    'key' => 'phone',
                    'name' => 'Контакт',
                    'type' => 'input',
                    'in_list' => true,
                ],
//                [
//                    'key' => 'email',
//                    'name' => 'Email',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'company',
//                    'name' => 'Организация',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
//                [
//                    'key' => 'city',
//                    'name' => 'Город',
//                    'type' => 'input',
//                    'in_list' => true,
//                ],
                [
                    'key' => 'text',
                    'name' => 'Комментарий',
                    'type' => 'textarea',
                    'in_list' => true,
                ],
                [
                    'key' => 'answer',
                    'name' => 'Ваш ответ',
                    'type' => 'textarea',
                    'in_list' => true,
                ],
                [
                    'key' => 'date',
                    'name' => 'Дата',
                    'type' => 'datepicker',
                    'is_int' => true,
                    'in_list' => true,
                ],
//                [
//                    'key' => 'file',
//                    'name' => 'Прикрепленный файл',
//                    'type' => 'file',
//                ],
            ],
        ],
    ],
];