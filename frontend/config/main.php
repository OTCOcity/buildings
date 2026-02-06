<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'apart-frontend',
    'name' => $params['sitename'],
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'layout' => 'main.twig',
    'timeZone' => 'Asia/Yekaterinburg',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%message}}',
                    'enableCaching' => true,
                    'cachingDuration' => 10,
                    'forceTranslation' => true,
                ],
                'menu' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%message}}',
                    'enableCaching' => true,
                    'cachingDuration' => 10,
                    'forceTranslation' => true,
                ],
                'buttons' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%message}}',
                    'enableCaching' => true,
                    'cachingDuration' => 10,
                    'forceTranslation' => true,
                ],
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => YII_DEBUG ? [
                        'debug' => true,
                        'auto_reload' => true,
                    ] : [],
                    'extensions' => YII_DEBUG ? [
                        '\Twig_Extension_Debug',
                    ] : [],

                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'MiscFunc' => '\frontend\components\MiscFunc',
                        'MiscBlocks' => '\frontend\components\MiscBlocks',
                        'MiscData' => '\frontend\components\MiscData',
                        'Language' => '\backend\eadmin\config\Language',
                    ],
//                    'uses' => ['yii\bootstrap'],
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin'],
        ],
//        'authManager' => [
//            'class' => 'yii\rbac\DbManager',
//        ],
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
            'errorAction' => 'statics/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'frontend\components\EAUrlRule'
                ]
            ],
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
            'cookieValidationKey' => "Ass7fI7PwWvv956y7",
        ],
    ],
    'params' => $params,
];
