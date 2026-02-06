<?php
namespace backend\controllers;

use frontend\models\Image;
use Yii;
use backend\eadmin\config\Config;
use tpmanc\imagick\Imagick;
use vova07\imperavi\actions\GetAction;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\UploadedFile;


class UploadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {


        die("Error");
    }


    // Crop изображения из админки
    public function actionCropimage() {

        $directoryRoot = Yii::getAlias('@frontend/web/upload/');
        $directory = Yii::getAlias('@frontend/web/upload/orig/');
        $directoryThumb = Yii::getAlias('@frontend/web/upload/thumb/');

        $x = (float)$_POST['x'];
        $y = (float)$_POST['y'];
        $w = (float)$_POST['w'];
        $h = (float)$_POST['h'];
        $id = (int)$_POST['id'];

        // Get image model
        $image = Image::findOne($id);
//        print_r($image->attributes);

        // Get config
        $config = Config::getConfig(preg_replace("/^(b_)|(c_)/ui", "", $image->table), preg_match("/^b_/ui", $image->table), $image->key);
//        print_r($config);

        // Get image folders
        foreach ($config['options']['resize'] as $key => $val) {
            $folderArr[] = $key;
        }

        $path = $directory . $image->file;
        $pathCopy = $directory . "backup_" . $image->file;
        if (file_exists($path)) {
//            copy($path, $pathCopy);

            $newName = uniqid(time(), true) . "." . array_pop(explode(".", $image->file));
            $oldName = $image->file;

            // Save table image
            $image->file = $newName;
            $image->save(false, ['file']);

            // Save table item
            $updateFld = preg_match("/^c_/ui", $image->table) ? 'thread_id' : 'id';
            Yii::$app->db->createCommand("
                UPDATE `{$image->table}`
                SET `{$image->key}` = '{$image->file}'
                WHERE `{$updateFld}` = '{$image->item_id}' 
                LIMIT 1
            ")->execute();

            $newPath = $directory . $image->file;

            Imagick::open($path)->crop($x, $y, $w, $h)->saveTo($newPath);
            @unlink($path);

            // Save to folders of resize
            foreach ($config['options']['resize'] as $resizeKey => $resize) {


                $newResizePath = $directoryRoot . $resizeKey . "/";

                Imagick::open($newPath)->thumb($resize['width'], $resize['height'])->saveTo($newResizePath . $image->file);
                @unlink($newResizePath . $oldName);
            }

            // Save to folders of thumb
            $newResizePath = $directoryRoot . 'thumb' . "/";
            Imagick::open($newPath)->thumb(100, 100)->saveTo($newResizePath . $image->file);
            @unlink($newResizePath . $oldName);

            return Json::encode([
                'oldName' => $oldName,
                'newName' => $image->file,
            ]);

        }


        return false;

    }

    // Загрузка изображения из админки (Select image)
    public function actionUploadimage() {


        foreach($_FILES as $file) {
            foreach ($file as $name) {
                $key = key($name);
                break;
            }
            break;
        }


        if ($catKey = $_POST['catkey']) {

            $config = Config::getConfig($catKey, false, $key);

        } elseif ($blockKey = $_POST['blockkey']) {

            $config = Config::getConfig($blockKey, true, $key);

        }


        $imageFile = UploadedFile::getInstanceByName('DynamicModel['.$key.']');
        $directoryRoot = Yii::getAlias('@frontend/web/upload/');
        $directory = Yii::getAlias('@frontend/web/upload/orig/');
        $directoryThumb = Yii::getAlias('@frontend/web/upload/thumb/');

        if (!is_dir($directory)) {mkdir($directory);}
        if (!is_dir($directoryThumb)) {mkdir($directoryThumb);}


        if ($imageFile) {

//            var_dump($imageFile);
//            die();

            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;

            if ($imageFile->saveAs($filePath)) {


                Imagick::open($filePath)->thumb(100, 100)->saveTo($directoryThumb . $fileName);
//

                if (is_array($config['options']['resize'])) {
                    foreach ($config['options']['resize'] as $resizeKey => $resize) {
                        $newResizePath = $directoryRoot . $resizeKey . "/";
                        if (!is_dir($newResizePath)) {
                            mkdir($newResizePath);
                        }

                        if (!$resize['width']) $resize['width'] = false;
                        if (!$resize['height']) $resize['height'] = false;

                        $imgToResize = Imagick::open($filePath);

                        if ( ($resize['height'] && $imgToResize->getHeight() > $resize['height']) || ($resize['width'] && $imgToResize->getWidth() > $resize['width'])) {
                            $imgToResize = $imgToResize->thumb($resize['width'], $resize['height']);
                        }
                        $imgToResize->saveTo($newResizePath . $fileName);
                    }
                }

                return Json::encode([
                    'files' => [[
                        'name' => $fileName,
                        'key' => $key,
                        'html' => $this->renderPartial("image-item.twig", [
                            'filename' => $fileName,
                            'ownName' => $imageFile->name,
                            'key' => $key,
                            'newimage' => true,
                            'inputName' => $catKey ? "StructureCat" : "StructureBlock"
                        ])
                    ]]
                ]);
            }
        }
        return '';

    }

    // Загрузка файла из админки (Select file)
    public function actionUploadfile() {


        foreach($_FILES as $file) {
            foreach ($file as $name) {
                $key = key($name);
                break;
            }
            break;
        }


        if ($catKey = $_POST['catkey']) {

            $config = Config::getConfig($catKey);

        } elseif ($blockKey = $_POST['blockkey']) {

            $config = Config::getConfig($blockKey, true);
        }


        $file = UploadedFile::getInstanceByName('DynamicModel['.$key.']');
        $directoryRoot = Yii::getAlias('@frontend/web/upload/');
        $directory = Yii::getAlias('@frontend/web/upload/orig/');
        $directoryResize = Yii::getAlias('@frontend/web/upload/resize/');
        $directoryThumb = Yii::getAlias('@frontend/web/upload/thumb/');

        if (!is_dir($directory)) {mkdir($directory);}
        if (!is_dir($directoryThumb)) {mkdir($directoryThumb);}
        if (!is_dir($directoryResize)) {mkdir($directoryResize);}


        if ($file) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $file->extension;
            $filePath = $directory . $fileName;

            if ($file->saveAs($filePath)) {

                if (exif_imagetype($filePath)) {

                    Imagick::open($filePath)->thumb(100, 100)->saveTo($directoryThumb . $fileName);
                    Imagick::open($filePath)->thumb(350, 350)->saveTo($directoryResize . $fileName);
                }

                return Json::encode([
                    'files' => [[
                        'name' => $fileName,
                        'key' => $key,
                        'html' => $this->renderPartial("file-item.twig", ['filename' => $fileName, 'ownName' => $file->name, 'key' => $key, 'newimage' => true, 'inputName' => $catKey ? "StructureCat" : "StructureBlock"])
                    ]]
                ]);
            }
        }
        return '';

    }





    public function actions()
    {
        return [
            'fileupload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::$app->params['siteurl'].'/upload/imperavifiles/', // Directory URL address, where files are stored.
                'path' => '@frontend/web/upload/imperavifiles', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => false
            ],
            'imageupload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::$app->params['siteurl'].'/upload/imperavi/', // Directory URL address, where files are stored.
                'path' => '@frontend/web/upload/imperavi' // Or absolute path to directory where files are stored.
            ],
            'imageget' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => Yii::$app->params['siteurl'].'/upload/imperavi/', // Directory URL address, where files are stored.
                'path' => '@frontend/web/upload/imperavi', // Or absolute path to directory where files are stored.
                'type' => GetAction::TYPE_IMAGES,
            ]
        ];
    }

}
