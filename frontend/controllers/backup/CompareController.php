<?php
namespace frontend\controllers\backup;

use common\models\Thread;
use frontend\components\Misc;
use frontend\models\CCart;
use frontend\models\CCompare;
use Yii;
use yii\web\Controller;


class CompareController extends Controller
{

    /**
     * Список товаров.
     *
     * @return mixed
     */
    public function actionIndex($id, $params)
    {
        $thread = Thread::findOne($id);
        $compare = $thread->model;

        $compare->activeType = $_GET['type'];


        $catThread = Thread::find()->where(['module' => 9])->one();

        Misc::$bodyClassname = "comparisonPage bgNum1";





        return $this->render('index.twig', ['compare' => $compare, 'catThread' => $catThread]);
    }



    /**
     * Добавление товара в сравнене
     * Формат адресов /action/p/a/r/a/m/s
     * @return json
     */
    public function actionView($id, $params)
    {


        $paramsArr = explode("/", $params);
        $action = $paramsArr[0];

        if (method_exists('frontend\models\CCompare', $action)) {

            CCompare::$action($paramsArr);
        }



        die();

    }





}
