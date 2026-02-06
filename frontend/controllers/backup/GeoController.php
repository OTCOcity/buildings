<?php
namespace frontend\controllers\backup;

use Yii;
use app\models\BGeoCities;
use common\models\Thread;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Geo controller
 */
class GeoController extends Controller
{

    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $info = $thread->model;


        $cities = BGeoCities::find()->where(['thread_id' => $info->thread_id, 'visible' => 1, 'region' => 0])->orderBy('name')->all();
        $regions = BGeoCities::find()->where(['thread_id' => $info->thread_id, 'visible' => 1, 'region' => 1])->orderBy('name')->all();

		
        return $this->render('index.twig', ['info' => $info, 'cities' => $cities, 'regions' => $regions]);
    }


    public function actionView($id, $params)
    {

        throw new ForbiddenHttpException();

    }


}
