<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_vac".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 */
class CVac extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_vac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id'], 'integer'],
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
            'name' => 'Name',
        ];
    }
}
