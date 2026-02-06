<?php

namespace frontend\controllers\backup;

use frontend\components\MiscFunc;
use Yii;
use frontend\models\BOrder;
use frontend\models\forms\CartForm;
use frontend\components\MiscBlocks;
use common\models\Thread;
use frontend\models\CCart;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;


class CartController extends Controller
{


    /**
     * Список товаров.
     */
    public function actionIndex($id, $params)
    {

        $thread = Thread::findOne($id);
        $cart = $thread->model;


        // Форма оформления заказа
        $cartForm = new CartForm();

        if (Yii::$app->request->isPost && $cartForm->load(Yii::$app->request->post())) {

            if ($cartForm->validate()) {

                $order = CCart::submitOrder();

                unset($_SESSION['cart']);


                $_SESSION['order_id'] = $order->id;

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'function' => "cartSubmit",
                    'data' => 12
                ];


            } else {
                Yii::$app->response->format = "json";
                return ActiveForm::validate($cartForm);
            }
        }


        return $this->render('index.twig', [
            'cart' => $cart,
            'cartForm' => $cartForm
        ]);
    }


    /**
     * Добавление / удаление товара в корзину
     */
    public function actionView($id, $params)
    {

        $paramsArr = explode("/", $params);

        if ($params == "clear") {

            unset($_SESSION['cart']);
            $this->redirect(MiscFunc::getThreadInfo('cart', 'url'));
            return;
        }

        if ($params == "submit") {

            return $this->actionSubmit();
        }

        if ($paramsArr[0] == "success") {
            return $this->actionCartSuccess($paramsArr);
        }


        // Запускаем метод модели корзины
        $paramsArr = explode("/", $params);
        $action = $paramsArr[0];

        if (method_exists('frontend\models\CCart', $action)) {

            $result = CCart::$action($paramsArr);

            return $result;
        }


        throw new ForbiddenHttpException;

    }


    public function actionCartSuccess()
    {

        if (!(int)$_SESSION['order_id']) {
            $this->redirect('/cart');
        }

        return $this->render("success.twig", ['orderId' => (int)$_SESSION['order_id']]);
    }
}
