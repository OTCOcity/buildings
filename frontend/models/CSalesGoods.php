<?php

namespace frontend\models;

/**
 * This is the model class for table "c_sales_goods".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 */
class CSalesGoods extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_sales_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    }



}