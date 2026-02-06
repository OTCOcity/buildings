<?php
return [
    'key' => 'options',
    'name' => 'Настройки',
    'icon' => 'cog',
    'tabs' => [
        [
            'name' => 'Общие',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
                [
                    'key' => 'sitename',
                    'name' => 'Название сайта',
                    'type' => 'input',
                ],
                [
                    'key' => 'slogan',
                    'name' => 'Слоган',
                    'type' => 'input',
                ],
//                [
//                    'key' => 'slogan_text',
//                    'name' => 'Заголовок в футере',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'copyrights',
//                    'name' => 'Копирайты',
//                    'type' => 'input',
//                ],
                [
                    'header' => 'Блок напишите мне',
                    'key' => 'fb_image',
                    'name' => 'Изображеие',
                    'type' => 'image',
                ],
                [
                    'key' => 'fb_title',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'fb_text',
                    'name' => 'Заголовок',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'fb_email',
                    'name' => 'Email',
                    'type' => 'input',
                ],
                [
                    'key' => 'fb_tg',
                    'name' => 'Telegram',
                    'type' => 'input',
                ],
                [
                    'header' => 'Контакты',
                    'key' => 'phone',
                    'name' => 'Телефон',
                    'type' => 'input',
                ],
                [
                    'key' => 'email',
                    'name' => 'E-mail',
                    'type' => 'input',
                ],
                [
                    'key' => 'email_personal',
                    'name' => 'E-mail для партнеров',
                    'type' => 'input',
                ],
                [
                    'key' => 'soc_tw',
                    'name' => 'Телеграм',
                    'type' => 'input',
                ],
                [
                    'key' => 'rek_address',
                    'name' => 'Адрес',
                    'type' => 'input',
                ],
                [
                    'key' => 'rek_ks',
                    'name' => 'Карта',
                    'type' => 'gmap',
                ],


//                [
//                    'key' => 'email',
//                    'name' => 'Email на сайте',
//                    'type' => 'input',
//                ],
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                        [
//                            'validator' => 'email',
//                            'options' => [],
//                        ],
//                    ]
//                [
//                    'key' => 'email_personal',
//                    'name' => 'Email для писем (можно несколько через запятую)',
//                    'type' => 'input',
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                        [
//                            'validator' => 'email',
//                            'options' => [],
//                        ],
//                    ]
//                ],
//                [
//                    'key' => 'email_personal',
//                    'name' => 'Email для заказов',
//                    'type' => 'input',
//                    'validate' => [
//                        [
//                            'validator' => 'required',
//                            'options' => [],
//                        ],
//                        [
//                            'validator' => 'email',
//                            'options' => [],
//                        ],
//                    ]
//                ],
            ],
        ],
        /*        [
                    'name' => 'Соцсети',
                    'icon' => 'share-alt',
                    'color' => 'blue',
                    'fields' => [
                        [
                            'key' => 'soc_inst',
                            'name' => 'Группа Instagram',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'soc_vk',
                            'name' => 'Группа Вконтакте',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'soc_fb',
                            'name' => 'Facebook',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'soc_tw',
                            'name' => 'Twitter',
                            'type' => 'input',
                        ],

                    ],
                ],*/
//        [
//            'name' => 'Статистика',
//            'icon' => 'star',
//            'color' => 'orange',
//            'fields' => [
//                [
//                    'key' => 'stats_objects',
//                    'name' => 'Количество объектов',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'stats_cities',
//                    'name' => 'Количество городов',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'stats_clients',
//                    'name' => 'Количество городов',
//                    'type' => 'input',
//                ],
//
//            ],
//        ],
//        [
//            'name' => 'Реквизиты',
//            'icon' => 'file-text-o',
//            'color' => 'red',
//            'fields' => [
//                [
//                    'key' => 'offer_doc',
//                    'name' => 'Договор оферты',
//                    'type' => 'file',
//                ],
//                [
//                    'key' => 'rek_name',
//                    'name' => 'Наименование',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_inn',
//                    'name' => 'Инн',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_kpp',
//                    'name' => 'Кпп',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_scet',
//                    'name' => 'Счет',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_bank',
//                    'name' => 'Банк',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_city',
//                    'name' => 'Город',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_bik',
//                    'name' => 'Бик',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_ks',
//                    'name' => 'Корр. счет',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'rek_address',
//                    'name' => 'Адрес',
//                    'type' => 'input',
//                ],
//            ],
//        ],
//        [
//            'name' => 'Ссылки на сайты',
//            'icon' => 'share-alt',
//            'color' => 'orange',
//            'fields' => [
//                [
//                    'key' => 'site_posrednik',
//                    'name' => 'Посредник',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'site_eks',
//                    'name' => 'Экскурсии',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'site_transfer',
//                    'name' => 'Трансфер',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'site_vnzh',
//                    'name' => 'ВНЖ',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'site_logistic',
//                    'name' => 'Логистика',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'site_business',
//                    'name' => 'Бизнес, юрист',
//                    'type' => 'input',
//                ],


//                [
//                    'key' => 'site_work',
//                    'name' => 'Работа',
//                    'type' => 'input',
//                ],
//                [
//                    'key' => 'site_clean',
//                    'name' => 'Клининг',
//                    'type' => 'input',
//                ],
//
//            ],
//        ],
        /*
                [
                    'name' => 'Юр. данные',
                    'icon' => 'file-text-o',
                    'color' => 'green',
                    'fields' => [
                        [
                            'key' => 'rek_fullname',
                            'name' => 'Полное наименование организации',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_name',
                            'name' => 'Краткое наименование организации',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_inn',
                            'name' => 'ИНН',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_kpp',
                            'name' => 'КПП',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_ur_adres',
                            'name' => 'Юридический адрес',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_ogrn',
                            'name' => 'ОГРН',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_rs',
                            'name' => 'Р/С',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_bank',
                            'name' => 'Банк',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_ks',
                            'name' => 'К/С',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_bik',
                            'name' => 'БИК',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_dir',
                            'name' => 'Директор ФИО',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_dir_r',
                            'name' => 'Директор ФИО (в родительном падеже)',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_dir_short',
                            'name' => 'Директор ФИО (сокращенно в поля подписи)',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_buh',
                            'name' => 'Бухгалтер',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_otv',
                            'name' => 'Ответственный',
                            'type' => 'input',
                        ],
                        [
                            'key' => 'rek_post',
                            'name' => 'Поставщик',
                            'type' => 'textarea',
                        ],
                        [
                            'key' => 'rek_go',
                            'name' => 'Грузоотправитель',
                            'type' => 'textarea',
                        ],

                    ],
                ],
        */
    ],
];