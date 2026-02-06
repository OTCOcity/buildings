<?php
namespace frontend\models\forms;

use yii\base\Model;

/**
 * CartForm
 */
class CartForm extends Model
{
    public $name;
    public $phone;
    public $email;

    public $street;
    public $house;
    public $korp;
    public $pod;
    public $flor;

    public $pay_type;
    public $comment;

    public function rules()
    {
        return [
            [['phone', 'name'], 'required'],
            [['email'], 'email'],
            [['street', 'house', 'korp', 'pod', 'flor', 'pay_type', 'comment'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'name' => 'Ваше имя',
        ];
    }



}
