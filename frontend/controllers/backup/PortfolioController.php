<?php
namespace frontend\controllers\backup;

use Yii;
use frontend\models\BPortfolio;
use common\models\Thread;
use frontend\components\Misc;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Sales controller
 */
class PortfolioController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {


        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Выводим первую акцию
        $portfolios = $page->portfolios;
        $portfolio = $portfolios[0];



        Misc::$bodyClassname = "textpage portfolio bgNum2";

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $portfolio->name];


        return $this->render('index.twig', ['page' => $page, 'thread' => $thread, 'portfolio' => $portfolio]);
    }


    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;


        $paramsArr = explode("/", $params);


        $portfolio = BPortfolio::findOne(['link' => $paramsArr[0], 'thread_id' => $thread->id]);

        if (count($paramsArr) > 1 || $portfolio === null) throw new HttpException(404 ,'Страница не существует');

        Misc::$bodyClassname = "textpage portfolio bgNum2";

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $portfolio->name];

        return $this->render('index.twig', ['page' => $page, 'thread' => $thread, 'portfolio' => $portfolio]);

    }


}
