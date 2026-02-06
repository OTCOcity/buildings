<?php
namespace frontend\controllers\backup;

use common\models\Thread;
use frontend\components\MiscFunc;
use frontend\models\BCatalogGoods;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SaleGoods controller
 */
class Sales_goodsController extends Controller
{

    /**
     * Список товаров.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {


        $thread = Thread::findOne($id);
        $model = $thread->model;

        MiscFunc::generateBlockSeo($model);

        // Товары
        $goods = BCatalogGoods::find()->where(['visible' => 1, 'sale_page' => 1])->orderBy('sale_sort')->all();


        return $this->render("index.twig", [
            'thread' => $thread,
            'model' => $model,
            'goods' => $goods
        ]);
    }


    public function actionView($id, $params)
    {
        throw new NotFoundHttpException();
    }


}
