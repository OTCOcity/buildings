<?php

namespace frontend\controllers\backup;

use frontend\models\BCatalogGoods;
use frontend\models\BNews;
use frontend\models\BSales;
use frontend\models\BStandart;
use frontend\models\CCatalogGroup;
use Yii;
use common\models\Thread;
use frontend\components\Misc;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Search controller
 */
class SearchController extends Controller
{

    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);

        $search = trim(Yii::$app->request->get('q'));

        $standart = BStandart::find()->where(['name' => $search])->one();

        if ($standart !== null) {

            return $this->redirect($standart->path);

        }

        $shortText = mb_strlen($search, 'utf-8') < 3;

        if (!$shortText) {
            $standarts = BStandart::find()->where(['like', 'name', $search])->all();
        }
        return $this->render("index.twig", [
            'standarts' => $standarts,
            'shortText' => $shortText,
            'q' => $search
        ]);

    }


    public function actionView($id, $params)
    {


        throw new NotFoundHttpException();


    }


    public function addWordsQuery($search, $query)
    {

        $searchArr = explode(" ", $search);
        foreach ($searchArr as $key => $val) {

            if (mb_strlen($val, "utf-8") > 4) {
                $searchArr[$key] = preg_replace("/[аеёиоуыэюя]{1,2}$/ui", "", $val);
            }

        }

        foreach ($searchArr as $val) {
            $query->andWhere(['like', 'name', $val]);
        }


        return $query;


    }


}
