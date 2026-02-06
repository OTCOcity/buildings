<?php

namespace frontend\controllers\backup;

use common\models\Thread;
use frontend\components\MiscFunc;
use frontend\models\crm\Client;
use frontend\models\crm\ClientRequests;
use frontend\models\crm\Object;
use frontend\models\crm\ObjectCity;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii as Yii;

/**
 * Object controller
 */
class ObjectController extends Controller
{

    public function actionIndex($id)
    {

        ini_set("memory_limit", "512M");

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Check client active requests
        if (!\Yii::$app->user->isGuest && !isset($_GET['city']) && !isset($_GET['rentType']) && !isset($_GET['roomType']) && !isset($_GET['priceFrom']) && !isset($_GET['priceTo'])) {

            $client = \Yii::$app->user->identity;
            $activeRequest = $client->getSiteActiveRequests()->one();
            if ($activeRequest !== null) {
                return $this->redirect("/realty?city={$activeRequest->city_id}&rentType={$activeRequest->rent_type}&roomType=" . $activeRequest->room . "");
            }
        }


        // Проверка выдачи (по заявке или нет)
        $roomTypes = is_array($_GET['roomType']) ? $_GET['roomType'] : explode(',', $_GET['roomType']);


        if (!array_filter($roomTypes, function ($v) { return $v !== '' && $v !== null;})) $roomTypes = ['1'];
        $isActiveRequest = ClientRequests::find()->where([
            'city_id' => (int)$_GET['city'],
            'rent_type' => (int)$_GET['rentType'],
            'room' => implode(',', $roomTypes),
            'status' => 1,
            'site' => 1,
        ])->andWhere(['>=', 'site_date', strtotime(date('d.m.Y 00:00:00'))])->exists();



        $objectsQuery = Object::find()->with('city');

        if (in_array((int)$_GET['rentType'], [0, 1])) {
            $objectsQuery->andWhere(['rent_type' => (int)$_GET['rentType']]);
        }

        if ($roomTypes) {

            $objectsQuery->andWhere(['in', 'room', $roomTypes]);
        }

        $city = false;
        if ((int)$_GET['city']) {
            $objectsQuery->andWhere(['city_id' => (int)$_GET['city']]);
            $city = ObjectCity::findOne((int)$_GET['city']);
        }

        if ((int)$_GET['priceFrom']) {
            $objectsQuery->andWhere(['>=', 'price', (int)$_GET['priceFrom']]);
        }

        if ((int)$_GET['priceTo']) {
            $objectsQuery->andWhere(['<=', 'price', (int)$_GET['priceTo']]);
        }

        if (!$city) {
            $objectsQuery->andWhere('0');
        }


        $pagination = new Pagination([
            'totalCount' => $objectsQuery->count(),
            'pageSize' => 50,
        ]);


        $objectsQuery->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy(['is_image' => SORT_DESC]);


        $objects = $objectsQuery->all();

        // Quer string without page
        $qs = preg_replace("/&page=\d+/ui", '', \Yii::$app->request->queryString);



        return $this->render('index.twig', [
            'page' => $page,
            'pagination' => $pagination,
            'thread' => $thread,
            'objects' => $objects,
            'city' => $city,
            'qs' => $qs,
            'requestRoomTypes' => $roomTypes,
            'isActiveRequest' => $isActiveRequest,
            'objectRoomTypes' => (new ClientRequests())->roomTypes,
            'objectRentTypes' => (new ClientRequests())->rentTypes,
        ]);
    }

    public function actionObjectPopup($params)
    {
        $objectId = (int)$params;
        $object = Object::find()->with('images')->where(['id' => $objectId])->limit(1)->one();

        if ($object === null || !\Yii::$app->request->isAjax) throw new NotFoundHttpException();

        return $this->renderPartial('object_popup.twig', [
            'object' => $object
        ]);

    }

    public function actionCityList($params)
    {

        $q = $_GET['q'];
        if (mb_strlen($q, 'utf-8') < 3) throw new NotFoundHttpException();

        $cities = ObjectCity::find()->select(['id', 'name'])->where(['like', 'name', $q])->asArray()->all();


        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'items' => $cities

        ];
    }

    /** Генерация картинки с телефоном объекта по id */
    public function actionObjectPhone() {

        $pause = mt_rand(500000, 2500000);
        usleep($pause);


        if (Yii::$app->user->isGuest) throw new ForbiddenHttpException();
        if (!Yii::$app->request->isPost ||!Yii::$app->request->isPost ) throw new ForbiddenHttpException();

        /** @var Object $object */
        $object = Object::findOne((int)$_POST['objectId']);

        if ($object === null || !$object->phone) throw new NotFoundHttpException();

        // Проверка доступа (по заявке)
        $clientRequest = ClientRequests::find()->where([
            'city_id' => $object->city_id,
            'rent_type' => $object->rent_type,
            'status' => 1,
            'site' => 1,
        ])->andWhere(['>=', 'site_date', strtotime(date('d.m.Y 00:00:00'))])->andWhere(['like', 'room', $object->room])->one();

        if ($clientRequest === null)  {
            throw new NotFoundHttpException();
        }

        $clientRequest->updateCounters(['phone_views' => 1]);

        $phone = MiscFunc::beautyPhone($object->phone);

        $im = imagecreatetruecolor(195, 25);

        $color = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $color);

        imagesavealpha($im, true);

        $font = Yii::getAlias('@frontend/web/fonts/arial.ttf');

        $textColor = imagecolorallocate($im, 51, 122, 183);

        imagettftext($im, 16, 0, 5, 19, $textColor, $font, $phone);

        imagepng($im);
        imagedestroy($im);

        $image_data = ob_get_contents();

        ob_end_clean();

        return base64_encode($image_data);

    }



    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            Client::updateAll(['sync_count' => time(), 'ip' => MiscFunc::getIp()], ['id' => Yii::$app->user->identity->id]);
        }

        return parent::beforeAction($action);
    }

}
