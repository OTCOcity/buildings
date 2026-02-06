<?php

namespace console\controllers;

use frontend\assets\AppAsset;
use yii\console\Controller;

class BuildController extends Controller
{

    public static $excludeDirs = ['views/backup', 'views/layouts'];

    public function actionIndex()
    {
        self::buildAppAssetsFile();
        self::buildViewFiles();
    }

    public static function buildViewFiles()
    {
        foreach (self::getDirContents(\Yii::getAlias('@frontend/views')) as $file) {

            if (is_file($file)) {

                $pathInfo = pathinfo($file);
                if ($pathInfo['extension'] === 'twig') {
                    $content = file_get_contents($file);
                    if (preg_match("/\?build_\w+/ui", $content)) {

                        $fileIsUpdated = false;

                        preg_match_all("/([^'\"]+)\?build_([^'\"]+)/ui", $content, $matches);
                        foreach ($matches[0] as $key => $jsFile) {

                            $jsFilePath = \Yii::getAlias('@frontend/web' . $matches[1][$key]);

                            $hash = file_exists($jsFilePath) ? md5_file($jsFilePath) : $matches[2][$key];

                            if ($hash !== $matches[2][$key]) {

                                $content = str_replace($matches[0][$key], $matches[1][$key] . '?build_' . $hash, $content);

                                $fileIsUpdated = true;
                            }
                        }


                        if ($fileIsUpdated) {
                            file_put_contents($file, $content);
                            echo "\e[32m" . $file . " - updated" . PHP_EOL;
                        } else {
                            echo "\e[31m" . $file . " - actual" . PHP_EOL;
                        }

                    }
                }
            }

        }
    }

    public static function buildAppAssetsFile()
    {
        $file = \Yii::getAlias('@frontend/assets/AppAsset.php');

        if (is_file($file)) {

            $pathInfo = pathinfo($file);
            $content = file_get_contents($file);
            if (preg_match("/\?build_\w+/ui", $content)) {

                $fileIsUpdated = false;

                preg_match_all("/([^'\"]+)\?build_([^'\"]+)/ui", $content, $matches);

                foreach ($matches[0] as $key => $jsFile) {

                    $jsFilePath = \Yii::getAlias('@frontend/web/' . $matches[1][$key]);

                    $hash = file_exists($jsFilePath) ? md5_file($jsFilePath) : $matches[2][$key];

                    if ($hash !== $matches[2][$key]) {

                        $content = str_replace($matches[0][$key], $matches[1][$key] . '?build_' . $hash, $content);

                        $fileIsUpdated = true;
                    }
                }


                if ($fileIsUpdated) {
                    file_put_contents($file, $content);
                    echo "\e[32m" . $file . " - updated" . PHP_EOL;
                } else {
                    echo "\e[31m" . $file . " - actual" . PHP_EOL;
                }

            }
        }
    }

    public static function getDirContents($dir, &$results = array())
    {

        $files = scandir($dir);

        foreach ($files as $key => $value) {

            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

            $isExclude = false;
            foreach (self::$excludeDirs as $excludeDir) {
                if (strpos($path, $excludeDir) !== false) {
                    $isExclude = true;
                }
            }

            if (!is_dir($path)) {

                if ($isExclude === false) {
                    $results[] = $path;
                }

            } else if ($value != "." && $value != "..") {
                self::getDirContents($path, $results);

                if ($isExclude === false) {
                    $results[] = $path;
                }


            }
        }

        return $results;
    }

}
