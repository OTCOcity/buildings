<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'And CMS',
    'language' => 'ru',
    'timeZone' => 'Asia/Yekaterinburg',
    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'layout' => '@backend/views/layouts/main.twig',
    'components' => [
        'view' => [
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    // set cachePath to false in order to disable template caching
                    'cachePath' => false, //'@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => YII_DEBUG ? [
                        'debug' => true,
                        'auto_reload' => true,
                    ] : [],
                    'extensions' => YII_DEBUG ? [
                        '\Twig_Extension_Debug',
                    ] : [],
                    // add Yii helpers or widgets here
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'language' => '\backend\eadmin\config\Language',
                        'misc' => '\backend\components\classes\Misc',
                        'miscFunc' => '\frontend\components\MiscFunc',
                        'datatypes' => '\backend\components\datatypes\Datatypes',
                    ]
                ]
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'arules' => [
            'class' => 'backend\components\classes\Arules',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                "admin/site/logout" => 'site/logout',
                "admin/site" => 'site/index',
                "admin" => 'site/index',
                "admin/upload/uploadimage" => 'upload/uploadimage',
                "admin/upload/uploadfile" => 'upload/uploadfile',

                "admin/upload/imageupload" => 'upload/imageupload',
                "admin/upload/imageget" => 'upload/imageget',

                "admin/site/login" => 'site/login',

                "admin/translate" => 'translate/index',
                "admin/translate/delete/<id:\d+>" => 'translate/delete',
                "admin/translate/edit/<id:\d+>" => 'translate/edit',


                "admin/users" => 'users/index',
                "admin/users/create" => 'users/create',
                "admin/users/<id:\d+>" => 'users/edit',
                "admin/users/delete/<id:\d+>" => 'users/delete',
                "admin/users/activetoggle/<id:\d+>" => 'users/activetoggle',


                "admin/threads" => 'site/index',
                "admin/threads/<id:\d+>" => 'threads/edit',
                "admin/threads/create" => 'threads/create',
                "admin/threads/delete/<id:\d+>" => 'threads/delete',

                "admin/realty-upload" => 'realty-upload/index',


                "admin/blocks/create/<table:\w+>/<threadid:\d+>/<blockkey:\w+>/<blockid:\d+>" => 'blocks/create',
                "admin/blocks/create/<table:\w+>/<threadid:\d+>" => 'blocks/create',
                "admin/blocks/<table:\w+>/<id:\d+>" => 'blocks/edit',
                "admin/blocks/delete/<table:\w+>/<id:\d+>" => 'blocks/delete',
                "admin/blocks/sortup/<table:\w+>/<id:\d+>" => 'blocks/sortup',
                "admin/blocks/sortdown/<table:\w+>/<id:\d+>" => 'blocks/sortdown',
                "admin/blocks/visibletoggle/<table:\w+>/<id:\d+>" => 'blocks/visibletoggle',
            ],
        ],

    ],
    'params' => $params,
];
