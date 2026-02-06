<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_palitra".
 *
 * @property integer $id
 * @property integer $thread_id
 */
class CPalitra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_palitra';
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

    public function getColors() {


        return $this->hasMany(BColors::className(), ['thread_id' => 'thread_id'])->orderBy('name');

    }

    public function getColorsSort() {


        return $this->hasMany(BColors::className(), ['thread_id' => 'thread_id'])->orderBy('color');

    }

}
