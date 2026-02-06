<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_access".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $thread_id
 * @property string $block_key
 * @property string $action
 */
class UserAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'thread_id', 'block_key'], 'required'],
            [['user_id', 'thread_id'], 'integer'],
            [['block_key', 'action'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'thread_id' => 'Thread ID',
            'block_key' => 'Block Key',
            'action' => 'Action',
        ];
    }
}
