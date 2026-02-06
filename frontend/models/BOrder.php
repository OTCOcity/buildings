<?php

namespace frontend\models;

use app\models\DataDelivType;
use app\models\DataPayType;
use app\models\DataType;
use Yii;

/**
 * This is the model class for table "b_order".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $client_name
 * @property string $client_phone
 * @property string $client_email
 * @property string $comment
 * @property string $session
 * @property string $order
 * @property integer $pay_type
 * @property integer $deliv_type
 * @property string $deliv_adres
 * @property string $file_dog
 * @property string $file_scet
 * @property string $currency
 * @property string $sum
 * @property string $nds
 * @property string $deliv_sum
 * @property string $sum_itog
 * @property string $city
 * @property string $date
 */
class BOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'pay_type', 'deliv_type'], 'integer'],
            [['comment'], 'safe'],
            [['block_key', 'name'], 'required'],
            [['sum', 'nds', 'deliv_sum', 'sum_itog'], 'number'],
            [['block_key', 'name', 'file_dog', 'file_scet'], 'string', 'max' => 50],
            [['deliv_adres'], 'string', 'max' => 1000],
            [['currency'], 'string', 'max' => 5],
            [['city'], 'string', 'max' => 100],
            [['date'], 'string', 'max' => 16],
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
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'name' => 'Name',
            'pay_type' => 'Pay Type',
            'deliv_type' => 'Deliv Type',
            'deliv_adres' => 'Deliv Adres',
            'file_dog' => 'File Dog',
            'file_scet' => 'File Scet',
            'currency' => 'Currency',
            'sum' => 'Sum',
            'nds' => 'Nds',
            'deliv_sum' => 'Deliv Sum',
            'sum_itog' => 'Sum Itog',
            'city' => 'City',
            'date' => 'Date',
        ];
    }


    public function getItemCount() {


        return BOrderItem::find()->where(['block_id' => $this->id, 'block_key' => 'order'])->count();
    }


    public function getPayType() {

        return $this->pay_type ? "Выставление счета" : "Оплата online";
    }

    public function getDelivType() {

        return $this->deliv_type ? "Самовывоз" : "Доставка до адреса";
    }

    public function getItems() {

        return $this->hasMany(BOrderItem::className(), ['block_id' => 'id'])->where(['block_key' => 'order']);
    }

    public function getTypestr() {

        if (!$this->type) $this->type = 1;

        return DataType::findOne($this->type)->name;
    }

    public function getDelivtypestr() {

        if (!$this->deliv_type) $this->deliv_type = 1;

        return DataDelivType::findOne($this->deliv_type)->name;
    }

    public function getPaytypestr() {

        if (!$this->pay_type) $this->pay_type = 1;

        return DataPayType::findOne($this->pay_type)->name;
    }


}
