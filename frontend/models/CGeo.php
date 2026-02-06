<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_geo".
 *
 * @property integer $id
 * @property integer $thread_id
 */
class CGeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_geo';
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
}
