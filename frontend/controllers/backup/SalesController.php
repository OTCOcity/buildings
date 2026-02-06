<?php
namespace frontend\controllers\backup;

use Yii;
use frontend\components\MiscFunc;
use frontend\models\BSales;
use common\models\Thread;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Sales controller
 */
class SalesController extends Controller
{

    public function actionIndex($id)
    {


        if ($getFilter = Yii::$app->request->get('sf')) {
            $getFilter = array_flip($getFilter);
        }

        $filters = BSales::getFilters($getFilter);

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Список акций
        $sales = BSales::find()->where(['thread_id' => $page->thread_id])->with('threads')->orderBy('sort')->all();

        $saleList = [];
        foreach ($sales as $val) {
            // if ($val->isActive && (!$getFilter || count(array_intersect_key ($getFilter, $val->threadsArr )))) { // применение фильтра
            if ((!$getFilter || count(array_intersect_key ($getFilter, $val->threadsArr )))) { // применение фильтра

                $saleList[] = $val;
            }
        }


        // Сегодняшняя дата
        $curDate = date("j", time()) . " " .mb_strtoupper(MiscFunc::$monthArr[date("n", time())], "utf-8") . " " . date("Y", time());

        return $this->render('index.twig', ['page' => $page, 'thread' => $thread, 'sales' => $saleList, 'curDate' => $curDate, 'filters' => $filters]);
    }


    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        $paramsArr = explode("/", $params);
        if (count($paramsArr) > 1) throw new HttpException(404 ,'Страница не существует');

        $sale = BSales::findOne(['link' => $paramsArr[0], 'thread_id' => $thread->id]);


        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $sale->name];



        return $this->render('view.twig', [
			'page' => $page, 
			'thread' => $thread, 
			'sale' => $sale
		]);

    }


}
