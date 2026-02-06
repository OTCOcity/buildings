<?php
namespace frontend\controllers\backup;

use frontend\components\MiscFunc;
use frontend\models\BServices;
use frontend\models\COptions;
use Yii;
use common\models\Thread;
use frontend\models\BPhones;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Services controller
 */
class ServicesController extends Controller
{

    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        $services = $page->services;



        return $this->render('index.twig', [
            'page' => $page,
            'thread' => $thread,
            'services' => $services,
        ]);
    }



    public function actionView($id, $params)
    {

        $service = BServices::find()->where(['visible' => 1, 'thread_id' => $id, 'link' => $params])->one();


        if ($service === null) {
            throw new NotFoundHttpException();
        }

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $service->name];
        MiscFunc::generateBlockSeo($service);


        return $this->render('view.twig', [
            'service' => $service,
        ]);
    }





}
