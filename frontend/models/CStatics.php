<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_statics".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $image
 * @property string $name
 * @property string $anons
 * @property string $text
 */
class CStatics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_statics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'image'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['anons'], 'string', 'max' => 1000],
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
            'image' => 'Image',
            'name' => 'Name',
            'anons' => 'Anons',
            'text' => 'Text',
        ];
    }


    public function getImages() {
        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->thread_id, 'table' => $this->tableName(), 'key' => 'image' ])
            ->all();

        return $result;
    }

}
