<?php
return [
    'key' => 'main',
    'name' => 'Главная страница',
    'icon' => 'home',
    'tabs' => [
        [
            'name' => 'Информация',
            'icon' => 'info',
            'color' => 'orange',
            'fields' => [
//                [
//                    'key' => 'image',
//                    'name' => 'Постеры для видео ниже (будут показаны до воспроизведения на мобильных устройствах)',
//                    'multiple' => true,
//                    'type' => 'image',
//                    'options' => [
//                        'count' => 99,
//                        'resize' => [
//                            'big' => [
//                                'width' => 900,
//                                'height' => 900,
//                                'type' => 'bestfit',
//                            ],
//                        ],
//                    ],
//                ],
                [
                    'key' => 'text_main',
                    'name' => 'Всплывающий текст',
                    'type' => 'input',
                ],
                [
                    'key' => 'text_price',
                    'name' => 'О нас',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'image',
                    'name' => 'Изображение для главного экрана',
                    'type' => 'image',
                    'rel_table' => 'image',
                    'options' => [
                        'count' => 1,
                        'resize' => [
                            'big' => [
                                'width' => 1920,
                                'height' => 1080,
                                'type' => 'bestfit',
                            ],
                            'medium' => [
                                'width' => 1024,
                                'height' => 768,
                                'type' => 'bestfit',
                            ],
                            'small' => [
                                'width' => 640,
                                'height' => 480,
                                'type' => 'bestfit',
                            ],
                        ],
                    ],
                    'in_list' => true,
                ],
                [
                    'key' => 'title',
                    'name' => 'Видео vimeo',
                    'type' => 'input',
                ],


                [
                    'header' => 'Блок Архитекция',
                    'key' => 'quote_sign',
                    'name' => 'Заголовок',
                    'type' => 'input',
                ],
                [
                    'key' => 'quote',
                    'name' => 'Автор цитаты',
                    'type' => 'ckeditor',
                ],
            ],
        ],
//        [
//            'name' => 'Слайды',
//            'icon' => 'newspaper-o',
//            'color' => 'blue',
//            'count_color' => 'primary',
//            'inner_blocks' => 'slide',
//        ],


    ],
]; 