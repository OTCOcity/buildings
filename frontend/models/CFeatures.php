<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_features".
 *
 * @property integer $id
 * @property integer $thread_id
 */
class CFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_features';
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


    public function getFeatures() {


        return $this->hasMany(BFeatures::className(), ['thread_id' => 'thread_id']);
    }


}
