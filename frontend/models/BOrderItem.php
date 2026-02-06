<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_order_item".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property integer $id_good
 * @property integer $id_variant
 * @property string $name
 * @property string $subname
 * @property string $color
 * @property string $color_name
 * @property integer $count
 * @property string $price
 * @property string $sum
 */
class BOrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'id_good', 'id_variant', 'count'], 'integer'],
            [['block_key', 'id_good', 'id_variant', 'name', 'subname', 'color', 'color_name', 'count'], 'required'],
            [['price', 'sum'], 'number'],
            [['block_key', 'color', 'color_name'], 'string', 'max' => 50],
            [['name', 'subname'], 'string', 'max' => 255],
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
            'id_good' => 'Id Good',
            'id_variant' => 'Id Variant',
            'name' => 'Name',
            'subname' => 'Subname',
            'color' => 'Color',
            'color_name' => 'Color Name',
            'count' => 'Count',
            'price' => 'Price',
            'sum' => 'Sum',
        ];
    }


    public function getGood() {


        return $this->hasOne(BCatalogGoods::className(), ['id' => 'id_good']);
    }
}
