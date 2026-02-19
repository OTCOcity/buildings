<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/normilize.css?build_1',
        '/css/app.css?build_1',
        '/css/building.css?build_2',
        '/css/files.css?build_2',
        '/css/balance.css?build_f4c016a80f666a5af1f4ada4b016f13b',
    ];
    public $js = [
        '/js/form.js?build_3fa959e1b73debdfdc692d78c874a612',
        '/js/app.js?build_3fa959e1b73debdfdc692d78c874a612',
    ];
    public $depends = [
        'yii\web\YiiAsset',

//        'yii\bootstrap\BootstrapAsset',
    ];
}
