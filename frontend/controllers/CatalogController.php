<?php

namespace frontend\controllers;

use common\models\Thread;
use frontend\components\AlfaBankApi;
use frontend\components\MiscData;
use frontend\components\MiscFunc;
use frontend\models\BOrder;
use frontend\models\BWork;
use frontend\models\CMain;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Catalog controller
 */
class CatalogController extends Controller
{

    /**
     * Список работ
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        // Set params
        Yii::$app->params['showMenuTitle'] = true;
        Yii::$app->params['showMenuBurger'] = true;
        Yii::$app->params['showLogoClass'] = 'is-blur-on-start is-active';
        Yii::$app->params['showClose'] = false;


        // Main page information
        $thread = Thread::findOne($id);

        /** @var CMain $page */
        $page = $thread->model;

        // Breadcrumbs
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::$app->params['siteName']];

        // Options
        $options = MiscFunc::getThreadData('options');

        // Works
        $worksQuery = BWork::find()
            ->where(['visible' => 1])
            ->orderBy(['group' => SORT_ASC, 'sort' => SORT_ASC, 'id' => SORT_DESC]);

        $groups = [];
        foreach ($worksQuery->all() as $work) {
            $groups[$work->group] = $work->group;
        }

        if (isset($_GET['group'])) {
            $worksQuery->andWhere(['group' => $_GET['group'] === '0' ? '' : $_GET['group']]);
        }

        $works = $worksQuery->all();


        return $this->render('list.twig', [
            'thread' => $thread,
            'page' => $page,
            'options' => $options,
            'works' => $works,
            'groups' => $groups,
        ]);
    }

    public function actionView($id, $params)
    {

        // Оформит заказ
        $paramsArr = explode('/', $params);
        if ($paramsArr[1] === 'buy') {
            return $this->actionBuy($id, $paramsArr[0]);
        }

        // Квллбек по заказу
        $paramsArr = explode('/', $params);
        if ($paramsArr[1] === 'order') {
            return $this->actionOrder($id, $paramsArr[0]);
        }

        // Состояние заказа
        $paramsArr = explode('/', $params);
        if ($paramsArr[1] === 'order-status') {
            return $this->actionOrderStatus();
        }

        // Set params
        Yii::$app->params['showMenuTitle'] = false;
        Yii::$app->params['showMenuBurger'] = true;
        Yii::$app->params['showLogoClass'] = 'hidden';
        Yii::$app->params['showClose'] = false;


        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Work
        /** @var BWork $work */
        $work = BWork::find()->where(['link' => $params])->one();
        if ($work === null) throw new NotFoundHttpException();

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $work->name];
        MiscFunc::generateBlockSeo($work);

        return $this->render("view.twig", [
            'thread' => $thread,
            'page' => $page,
            'work' => $work
        ]);
    }

    public function actionBuy($id, $params)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Work
        /** @var BWork $work */
        $work = BWork::find()->where(['link' => $params])->one();
        if ($work === null) throw new NotFoundHttpException();
        if (+$work->buy_link <= 0) throw new NotFoundHttpException();

        $order = new BOrder();
        $order->thread_id = Thread::findOne(['module' => 13])->id;
        $order->lang = 'ru';
        $order->sum_itog = +$work->buy_link;
        $order->block_key = '';
        $order->save(false);
        $order->source_id = $order->id;
        $order->name = $order->id;
        $order->date = date('d.m.Y');
        $order->save(false);

        $response = AlfaBankApi::regOrder($order->id, ((float)$order->sum_itog) * 100, "Оплата товара «{$work->name}»‎", Yii::$app->params['siteurl'] . "{$work->url}/order");

        // В случае ошибки вывести ее
        if (isset($response['errorCode'])) {
            return $this->renderContent('<h1 style="margin-top: 150px; text-align: center;">Ошибка #' . $response['errorCode'] . ': ' . $response['errorMessage'] . '</h1>');
        }


        $order->comment = Yii::$app->params['siteurl'] . "{$work->url}/order-status?orderId={$response['orderId']}";
        $order->text = $response['orderId'];
        $order->session = 'Не оплачен';
        $order->save(false);

        header('Location: ' . $response['formUrl']);
        die();

    }

    public function actionOrder($id, $params)
    {

//        $thread = Thread::findOne($id);
//        $page = $thread->model;

        $work = BWork::find()->where(['link' => $params])->one();
//        if ($work === null) throw new NotFoundHttpException();

        $order = BOrder::findOne(['text' => $_GET['orderId']]);
        if ($order) {
            $order->session = 'Ввел карту';
            $order->save(false);
        }


        return $this->actionOrderStatus();

    }

    public function actionOrderStatus()
    {

        if (!$_GET['orderId']) throw new NotFoundHttpException();

        $order = BOrder::findOne(['text' => $_GET['orderId']]);
        if ($order === null) {
            return $this->renderContent('<h1 style="margin-top: 150px; text-align: center;">Такого платежа не существует :\'(</h1>');
        }

        $response = AlfaBankApi::statusOrder($_GET['orderId']);

        $order->session = $response['ErrorMessage'];
        $order->save(false);

        if (isset($response['ErrorCode']) && $response['ErrorCode'] != 0) {
            return $this->renderContent('<h1 style="margin-top: 150px; text-align: center;">Ошибка #' . $response['ErrorCode'] . ': ' . $response['ErrorMessage'] . '</h1>');
        } else {
            return $this->renderContent("<h1 style='margin-top: 150px; text-align: center;'>Заказ #{$response['OrderNumber']}. {$response['ErrorMessage']} - {$response['Amount']} руб.");
        }


    }
}