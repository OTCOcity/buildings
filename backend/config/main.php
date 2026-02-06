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
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'layout' => 'main.twig',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                "users/<id:\d+>" => 'users/edit',
                "users/delete/<id:\d+>" => 'users/delete',
                "users/activetoggle/<id:\d+>" => 'users/activetoggle',

                "threads/<id:\d+>" => 'threads/edit',
                "threads/delete/<id:\d+>" => 'threads/delete',

                "blocks/create/<table:\w+>/<threadid:\d+>/<blockkey:\w+>/<blockid:\d+>" => 'blocks/create',
                "blocks/create/<table:\w+>/<threadid:\d+>" => 'blocks/create',
                "blocks/<table:\w+>/<id:\d+>" => 'blocks/edit',
                "blocks/delete/<table:\w+>/<id:\d+>" => 'blocks/delete',
                "blocks/sortup/<table:\w+>/<id:\d+>" => 'blocks/sortup',
                "blocks/sortdown/<table:\w+>/<id:\d+>" => 'blocks/sortdown',
                "blocks/visibletoggle/<table:\w+>/<id:\d+>" => 'blocks/visibletoggle',
            ],
        ],

    ],
    'params' => $params,
];
