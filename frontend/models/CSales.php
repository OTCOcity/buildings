<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_sales".
 *
 * @property integer $id
 * @property integer $thread_id
 */
class CSales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id'], 'integer'],
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
        ];
    }


    public function getSales() {


        return $this->hasMany(BSales::className(), ['thread_id' => 'thread_id']);

    }


}
