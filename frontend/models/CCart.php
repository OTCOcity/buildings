<?php

namespace frontend\models;

use frontend\components\MiscBlocks;
use frontend\components\MiscFunc;
use Yii;

/**
 * This is the model class for table "c_cart".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 */
class CCart extends \yii\db\ActiveRecord
{

    public $sum = 0;
    public $sumItog = 0;
    public $volume = 0;
    public $weight = 0;
    public $delivSum = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thread_id' => 'Thread ID',
            'name' => 'Name',
        ];
    }


    public function getItems()
    {

        $cart = $_SESSION['cart'];
        if (!is_array($cart)) $cart = [];

        $items = [];
        $sum = 0;
        foreach ($cart as $item) {

            $good = BCatalogGoods::findOne($item->good_id);

            $items[] = (object)[
                'good' => $good->attributes,
                'size' => $item->size,
                'count' => $item->count,
            ];

            $sum += (float)($good->price) * (int)$item->count;

        }


        $this->sum = $sum;


        return $items;
    }


    static function setcount($params)
    {

        $goodId = (int)$params[1];
        $count = (int)$params[2];
        $size = $params[3];


        $cart = is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

        $key = $size ? $goodId . "." . $size : $goodId;
        $cart[$key] = (object)[
            'good_id' => $goodId,
            'size' => $size,
            'count' => $count,
        ];

        if ($count == 0) {
            unset($cart[$key]);
        }

        $_SESSION['cart'] = $cart;


        return MiscBlocks::cartHeader();
    }


    /**
     * Оформление заказа
     */
    static public function submitOrder()
    {

        // Сохранение введенных данных
        $post = Yii::$app->request->post();
        $data = $post['CartForm'];

        // Создаем корзину
        $cart = new CCart();
        $cartItems = $cart->items;

        // Создаем и сохраняем заказ
        $order = new BOrder();
        $order->thread_id = MiscFunc::getThreadInfo('cart', 'id');
        $order->pay_type = $data['pay_type'];
        $order->client_name = $data['name'];
        $order->client_phone = $data['phone'];
        $order->client_email = $data['email'];
        $order->deliv_adres = "{$data['street']} {$data['house']}, корпус {$data['korp']}, подъезд {$data['pod']}, этаж {$data['flor']} ";
        $order->comment = mb_substr($data['comment'], 0, 1000, 'utf-8');
        $order->comment = $data['comment'];
        $order->sum_itog = (float)$cart->sum;
        $order->date = date("d.m.Y", time());
        $order->session = session_id();


        // Сохраняем позиции заказа
        $orderText = "
            <tr>
                <td>№</td>
                <td>Артикул</td>
                <td>Товар</td>
                <td>Кол-во</td>
                <td>Цена</td>
                <td>Сумма</td>
            </tr>
        ";
        foreach ($cartItems as $key => $item) {
            $orderText .= "
                <tr>
                    <td>". ($key + 1) .".</td>
                    <td>{$item->good['article']}</td>
                    <td>{$item->good['name']} {$item->size}</td>
                    <td>{$item->count}</td>
                    <td>{$item->good['price']}</td>
                    <td>". ($item->count * $item->good['price']) ."</td>
                </tr>
            ";
        }
        $order->order = "<table>{$orderText}<tr><td colspan='5'>ИТОГО: {$order->sum_itog}</td></tr></table>";
        $order->save(false);
        $order->name = $order->id;
        $order->save(false);


        // Email to admin
        $subject = "Новый заказ на сайте " . MiscFunc::getThreadData('options', 'sitename');

        $emails = preg_split('/[;,]/', MiscFunc::getThreadData('options', 'email_personal'));
        $recipients = [];
        foreach($emails as $email){
            $recipients[] = trim($email);
        }

        Yii::$app->mailer->compose('toadmin/order.php', ['subject' => $subject, 'order' => $order, 'cartItems' => $cartItems])
            ->setFrom(Yii::$app->params['siteRobotEmail'])
            ->setTo($recipients)
            ->setSubject($subject)
            ->send();




        // Email to user
//        $subject = "Ваш заказ на сайте " . MiscFunc::getThreadData('options', 'sitename');
//        Yii::$app->mailer->compose('touser/order.php', ['subject' => $subject, 'order' => $order])
//            ->setFrom(Yii::$app->params['siteRobotEmail'])
//            ->setTo($order->client_email)
//            ->setSubject($subject)
//            ->send();


        return $order;

    }


    public function getNds()
    {

        return $this->sum * 0.18;
    }


    public function getDelivPrice($city, $deliv_type)
    {

        $result = "";
        if ($city && $deliv_type) {

            $result = 1000;

        } else {

            $result = 0;
        }

    }


}
