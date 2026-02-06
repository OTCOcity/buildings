<?php

namespace frontend\controllers;

use common\models\Thread;
use frontend\models\BWork;
use frontend\models\CMain;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PresentationController extends Controller
{

    public function actionIndex()
    {

        // Set params
        \Yii::$app->params['showMenuTitle'] = false;
        \Yii::$app->params['showMenuBurger'] = true;
        \Yii::$app->params['showLogoClass'] = 'hidden';
        \Yii::$app->params['showClose'] = false;


        $mainPageInfo = CMain::find()->one();
        $presFile = $mainPageInfo->image;

        $presWork = null;
        if ($mainPageInfo->title) {
            $presWork = BWork::findOne(['name' => $mainPageInfo->title]);
        }

        \Yii::$app->params['breadcrumbs'][] = ['label' => 'M&M - Презентация', 'url' => '/presentation'];
        \Yii::$app->params['seo_keywords'] = 'M&M - Презентация';
        \Yii::$app->params['seo_description'] = 'M&M - Презентация';

        if ($presWork !== null) {

            return $this->workRender($presWork);

        } elseif ($presFile) {

            return $this->fileRender($presFile);

        } else {

            throw new NotFoundHttpException();
        }

    }

    public function workRender($presWork) {

        $thread = $presWork->thread;

        return $this->render('/catalog/view.twig', [
            'thread' => $thread,
            'page' => $thread->model,
            'work' => $presWork,
            'isPresentation' => true

        ]);
    }

    public function fileRender($presFile) {

        $filePath = \Yii::getAlias('@frontend' . '/web/upload/orig/' . $presFile);
        if (!is_file($filePath)) throw new NotFoundHttpException('File not found');

        ob_start();
        header ('Content-Type: ' . mime_content_type($filePath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);

        exit(0);

    }


}
