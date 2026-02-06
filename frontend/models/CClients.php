<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_clients".
 *
 * @property integer $id
 * @property integer $thread_id
 */
class CClients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_clients';
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
