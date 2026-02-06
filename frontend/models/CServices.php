<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_services".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 * @property string $anons
 * @property string $text
 * @property integer $image
 */
class CServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'image'], 'integer'],
            [['name', 'anons', 'text', 'image'], 'required'],
            [['text'], 'string'],
            [['name', 'anons'], 'string', 'max' => 255],
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
            'anons' => 'Anons',
            'text' => 'Text',
            'image' => 'Image',
        ];
    }


    public function getServices() {


        return $this->hasMany(BServices::className(), ['thread_id' => 'thread_id'])->where(['visible' => 1])->orderBy('sort, id');

    }


}
