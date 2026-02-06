<?php

namespace frontend\models;

use frontend\components\Misc;
use frontend\components\MiscFunc;
use Yii;

/**
 * This is the model class for table "b_good_variant".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property integer $price
 * @property string $old_price
 * @property string $sale
 */
class BGoodVariant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_good_variant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'sale'], 'integer'],
            [['block_key'], 'string', 'max' => 50],
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
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'name' => 'Name',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'sale' => 'Скидка',
        ];
    }



    /**
     * Цена на товар
     * @return float
     */
    public function getCartPrice() {
		
		if (empty($this->price) && $this->price !== '0') return false;
		
        return MiscFunc::smartStrToPrice($this->price);
    }

    public function getCartOldPrice() {

        return MiscFunc::smartStrToPrice($this->old_price);
    }


    /**
     * Находится ли данный вариант в корзине
     * @return boolean
     */
    public function getIncart() {

        if (!is_array($_SESSION['cart'])) return false;

        foreach ($_SESSION['cart'] as $val) {
            if ($val->variant_id == $this->id) {

                return $val->count;
            }
        }
        return false;
    }


    /**
     * Товар к которому относится вариант
     * @return boolean
     */
    public function getGood() {

        return $this->hasOne(BCatalogGoods::className(), ['id' => 'block_id']);
    }




}
