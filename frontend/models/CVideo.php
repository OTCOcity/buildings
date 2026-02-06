<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_video".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 * @property string $anons
 * @property string $text
 * @property integer $image
 */
class CVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_video';
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


    public function getVideos() {


        return $this->hasMany(BVideo::className(), ['thread_id' => 'thread_id'])->where(['lang' => Yii::$app->language]);

    }

    public function getLastVideo() {


        return BVideo::find()->where(['thread_id' => $this->thread_id, 'lang' => Yii::$app->language])->limit(3)->all();

    }

}
