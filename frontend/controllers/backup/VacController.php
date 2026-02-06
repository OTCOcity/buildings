<?php
namespace frontend\controllers\backup;

use frontend\components\MiscFunc;
use frontend\models\BVac;
use Yii;
use common\models\Thread;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Articles controller
 */
class VacController extends Controller
{
    public $layout = "inner_small.twig";


    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $info = $thread->model;

        // Первая вакансия
        // $vac = BVac::find()->where(['thread_id' => $info->thread_id])->orderBy('sort')->one();

        // Все вакансии
        $vacList = BVac::find()->where(['visible' => 1])->orderBy('sort')->all();

		

        return $this->render('index.twig', ['thread' => $thread, 'info' => $info, 'vacList' => $vacList]);
    }


    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $info = $thread->model;

        $id = (int)$params;

        $vac = BVac::findOne($id);
        if ($vac === null) throw new ForbiddenHttpException;

        // Все вакансии
        $vacList = BVac::find()->where(['visible' => 1])->orderBy('sort')->all();

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $vac->name];
        MiscFunc::generateBlockSeo($vac);

        return $this->render('view.twig', ['thread' => $thread, 'info' => $info, 'vac' => $vac, 'vacList' => $vacList]);

    }


}
