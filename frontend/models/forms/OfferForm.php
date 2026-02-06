<?php

namespace frontend\models\forms;

use yii\base\Model;

/**
 * Offer Form
 */
class OfferForm extends Model
{
    public $accept;

    public function rules()
    {
        return [
            [['accept'], 'required'],
            ['accept', 'compare', 'compareValue' => 1, 'message' => 'Вы должны согласиться с Договором оферты чтобы продолжить']
        ];
    }

    public function attributeLabels()
    {
        return [
            'accept' => 'Я принимаю условия договора оферты',
        ];
    }

}
