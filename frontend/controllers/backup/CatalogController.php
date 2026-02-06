<?php

namespace frontend\controllers\backup;

use backend\eadmin\config\Language;
use common\models\Thread;
use frontend\components\MiscFunc;
use frontend\models\BObject;
use frontend\models\BOrder;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Sales controller
 */
class CatalogController extends Controller
{

    /**
     * Список товаров.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        $order = new \frontend\models\BOrder();
        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Objects
        $objectsQuery = BObject::find()->where(['visible' => 1, 'lang' => Language::getLang()])->orderBy(['is_super' => SORT_DESC, 'is_hot' => SORT_DESC, 'b_object.sort' => SORT_ASC]);

        $isSearch = false;


        // Search rent type
        $rentQuery = MiscFunc::queryGet('rent');
        if ($rentQuery && $rentQuery !== 'all') {
            $objectsQuery->leftJoin('obj_rent_type r', 'r.id = b_object.obj_rent_type_id')
                ->andWhere(['r.name' => $rentQuery]);
            $isSearch = true;
        }

        // Search type
        $typeQuery = MiscFunc::queryGet('type');
        if ($typeQuery && $typeQuery !== 'all') {
            $objectsQuery->leftJoin('obj_type t', 't.id = b_object.obj_type_id')
                ->andWhere(['t.name' => $typeQuery]);
            $isSearch = true;
        }

        // Search room type
        $roomQuery = MiscFunc::queryGet('room');
        if ($roomQuery && $roomQuery !== 'all') {
            $objectsQuery->leftJoin('obj_room_type room', 'room.id = b_object.obj_room_type_id')
                ->andWhere(['room.name' => $roomQuery]);
            $isSearch = true;
        }

        // Search city
        $cityQuery = MiscFunc::queryGet('city');
        if ($cityQuery && $cityQuery !== 'all') {
            $objectsQuery->leftJoin('obj_city c', 'c.id = b_object.obj_city_id')
                ->andWhere(['c.name' => $cityQuery]);
            $isSearch = true;
        }

        // Search district
        $districtQuery = MiscFunc::queryGet('district');
        if ($districtQuery && $districtQuery !== 'all') {
            $objectsQuery->leftJoin('obj_district d', 'd.id = b_object.obj_district_id')
                ->andWhere(['d.name' => $districtQuery]);
            $isSearch = true;
        }

        // Pagination
        $page  = (int)Yii::$app->request->get('p') ? (int)Yii::$app->request->get('p') : 1;
        $pagination = new Pagination(['totalCount' => $objectsQuery->count(), 'pageSize' => 18, 'page' => $page - 1]);
        $pagination->route = preg_replace('/&p=[^&]/ui', '', Yii::$app->request->url);
        $pagination->route = trim(preg_replace('/\?p=[^&]&?/ui', '?', $pagination->route), '?');


        $objects = $objectsQuery->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render("index.twig", [
            'thread' => $thread,
            'page' => $page,
            'objects' => $objects,
            'pagination' => $pagination,
            'isSearch' => $isSearch
        ]);

    }

    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Object
        $object = BObject::find()->where(['link' => $params])->one();
        if ($object === null) throw new NotFoundHttpException();

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $object->name];
        MiscFunc::generateBlockSeo($object);


        return $this->render("view.twig", [
            'thread' => $thread,
            'page' => $page,
            'object' => $object
        ]);
    }
    /**
     * Autocomplete for search (json)
     * @return Json
     */
    public function autocomplete()
    {
        die();

        $query = trim(strip_tags($_GET['query']));

        $rows = (new Query())->select('name as value')
            ->from('b_catalog_goods')
            ->where("name like '%{$query}%'")->all();

        $result = [
            'query' => $query,
            'suggestions' => $rows,
        ];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        return ($result);
    }

}
