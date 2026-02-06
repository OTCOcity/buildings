<?php

namespace frontend\components;

class AlfaBankApi
{

    public static $regOrderUrl = 'https://web.rbsuat.com/ab/rest/register.do';
    public static $statusOrderUrl = 'https://web.rbsuat.com/ab/rest/getOrderStatus.do';

    static public function regOrder($orderId, $amount, $description, $returnUrl) {

        $login = \Yii::$app->params['alfaBankApi']['login'];
        $password = \Yii::$app->params['alfaBankApi']['password'];
        if (!$login || !$password) throw new \Exception('Pay Api login error!');


        $data = array(
            'userName' => $login,
            'password' => $password,
            'orderNumber' => $orderId,
            'amount' => $amount,
            'description' => $description,
            'returnUrl' => $returnUrl
        );


        $curl = curl_init(); // Инициализируем запрос
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$regOrderUrl, // Полный адрес метода
            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            CURLOPT_POST => true, // Метод POST
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($curl); // Выполняем запрос

        $response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение


        return $response; // Возвращаем ответ

    }

    static public function statusOrder($orderId) {

        $login = \Yii::$app->params['alfaBankApi']['login'];
        $password = \Yii::$app->params['alfaBankApi']['password'];
        if (!$login || !$password) throw new \Exception('Pay Api login error!');


        $data = array(
            'userName' => $login,
            'password' => $password,
            'orderId' => $orderId,
        );


        $curl = curl_init(); // Инициализируем запрос
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$statusOrderUrl, // Полный адрес метода
            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            CURLOPT_POST => true, // Метод POST
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($curl); // Выполняем запрос

        $response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение

        return $response; // Возвращаем ответ

    }

}