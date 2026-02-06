<?php
namespace frontend\controllers\backup;

use frontend\components\MiscFunc;
use frontend\models\BCatalogGoods;
use frontend\models\FilterAge;
use frontend\models\FilterSize;
use Yii;
use app\models\BBenefit;
use common\models\Thread;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Sales controller
 */
class Catalog_groupController extends Controller
{

    /**
     * Список товаров.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $group = $thread->model;

        MiscFunc::generateBlockSeo($group);


        $filters = Yii::$app->request->queryParams;
        unset($filters['id']);
        unset($filters['params']);

        $filtersWithoutPage = $filters;
        unset($filtersWithoutPage['page']);
        $filterQuery = http_build_query($filtersWithoutPage);


        $goodQuery = BCatalogGoods::find()->where(['thread_id' => $thread->id, 'visible' => 1]);
        $goodQuery = BCatalogGoods::queryFilter($goodQuery, $filters);


        $count = $goodQuery->count();
        $page = $goodQuery->offset / BCatalogGoods::getPageLimit() + 1;
        $pageCount = ceil($count / BCatalogGoods::getPageLimit());



        $goods = $goodQuery->all();

        // Size list
        $filterSizeList = [];
        foreach (FilterSize::find()->where(['thread_id' => $thread->id])->orderBy('sort')->all() as $size) {
            $filterSizeList[] = (object)[
                'size' => $size->size,
                'value' => $size->sort,
                'active' => mb_strpos($filters['size'] . ';', $size->sort, 0, 'utf-8') !== false || (mb_strpos($filters['size'], $size->sort, -1, 'utf-8') !== false && mb_strpos($filters['size'], $size->sort, -1, 'utf-8') == mb_strlen($filters['size'], "utf-8") - mb_strlen($size->sort, "utf-8"))

            ];
        }

        // Age list
        $filterAgeList = [];
        foreach (FilterAge::find()->where(['thread_id' => $thread->id])->orderBy('sort')->all() as $age) {
            $filterAgeList[] = (object)[
                'age' => $age->age,
                'value' => $age->sort,
                'active' => mb_strpos($filters['age'] . ';', $age->sort, 0, 'utf-8') !== false || (mb_strpos($filters['age'], $age->sort, -1, 'utf-8') !== false && mb_strpos($filters['age'], $age->sort, -1, 'utf-8') == mb_strlen($filters['age'], "utf-8") - mb_strlen($age->sort, "utf-8"))

            ];
        }





        return $this->render("group.twig", [
            'thread' => $thread,
            'group' => $group,
            'goods' => $goods,
            'count' => $count,
            'page' => $page,
            'pageCount' => $pageCount,
            'filterSizeList' => $filterSizeList,
            'filterAgeList' => $filterAgeList,
            'filters' => $filters,
            'filterQuery' => $filterQuery,
        ]);
    }


    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $group = $thread->model;


        $good = BCatalogGoods::find()->where(['visible' => 1, 'link' => $params])->one();

        if ($good === null) throw new NotFoundHttpException();

        // История товаров
        if (!in_array($good->id, $_SESSION['catalog_history'])) {
            $_SESSION['catalog_history'][] = $good->id;
            $_SESSION['catalog_history'] = array_slice($_SESSION['catalog_history'], -4, 4);
        }


        // Breadcrumbs add
//        Yii::$app->params['breadcrumbs'][] = ['label' => $good->name, 'url' => $good->url];

        MiscFunc::generateBlockSeo($good);

//        var_dump($good->getSimilars()->createCommand()->getRawSql());
//        var_dump($good->similars);
//        var_dump($good->images);
//        die();

        return $this->render("product.twig", [
            'thread' => $thread,
            'group' => $group,
            'good' => $good,
        ]);

    }


}
