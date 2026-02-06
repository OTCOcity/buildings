<?php

namespace frontend\models\forms;

use frontend\components\MiscFunc;
use frontend\models\crm\Client;
use frontend\models\crm\ClientRequests;
use frontend\models\crm\ObjectCity;
use yii\base\Model;

/**
 * Registration Form
 *
 *  * @property ObjectCity $city
 */
class RegForm extends Model
{
    public $name;
    public $phone;
    public $city_id;
    public $rent_type;
    public $room_type;
    public $agree_ps;
    public $agree_ki;


    public function rules()
    {
        return [
            [['name', 'phone', 'city_id', 'rent_type', 'room_type'], 'required'],
            [['phone'], 'validatePhone'],
            ['agree_ki', 'compare', 'compareValue' => 1, 'message' => 'Ознакомиться с политикой обработки персональных данных'],
            ['agree_ps', 'compare', 'compareValue' => 1, 'message' => 'Ознакомиться с условиями пользовательского соглашения'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Фио',
            'phone' => 'Телефон',
            'city_id' => 'Город',
            'rent_type' => 'Тип аренды',
            'room_type' => 'Тип комнат',
        ];
    }

    public function validatePhone($attribute, $params)
    {

        $phone = MiscFunc::trimPhone($this->phone, 10);

        if (mb_strlen($phone, 'utf-8') < 10) {
            $this->addError($attribute, 'Слишком короткий номер телефона');
        }

        if (Client::findOne(['phone_dig' => $phone])) {
            $this->addError($attribute, 'Такой телефон уже зарегистрирован');
        }
    }


    public function getCity()
    {
        return ObjectCity::find()->select(['id', 'name'])->where(['id' => $this->city_id])->asArray()->one();
    }


    public function registration()
    {

        $client = new Client();

        $client->name = $this->name;
        $client->phone = $this->phone;
        $client->phone_dig = MiscFunc::trimPhone($this->phone);
        $client->type = 0;
        $client->adres = $this->city->name;
        $client->color = 5; // Фиолетовые
        $client->password_hash = mb_strtolower(\Yii::$app->security->generateRandomString(6), 'utf-8');
        $client->generateAuthKey();
        $client->save(false);

        $client->login = mb_strtolower(\Yii::$app->security->generateRandomString(3) . '-' . $client->id);
        $client->save(false, ['login']);

        $clientRequest = new ClientRequests();
        $clientRequest->client_id = $client->id;
        $clientRequest->city_id = $this->city_id;
        $clientRequest->room = implode(',', $this->room_type);
        $clientRequest->rent_type = $this->rent_type;
        $clientRequest->site = 1;
        $clientRequest->site_date = time() + 86400 * 30;
        $clientRequest->status = 0;
        $clientRequest->period_begin_date = time();
        $clientRequest->period_end_date = time() + 86400 * 30;
        $clientRequest->save(false);


        return $client;
    }

}
