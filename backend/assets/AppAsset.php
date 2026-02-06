<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@backend/web';
    public $css = [
        'css/font-awesome.css',
        'js/cropper-master/cropper.min.css',
        'css/admin.css',
        'css/ace.css',
    ];
    public $js = [
        'js/jquery.cookie.js',
        'js/cropper-master/cropper.min.js',
        'js/datatypes/gmap.js',
        'js/admin.js',
        'js/ace/ace.js',
        'js/ace/dataTables/jquery.dataTables.js',
        'js/ace/dataTables/jquery.dataTables.bootstrap.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}