<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_contacts".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $image
 * @property string $name
 * @property string $text
 */
class CContacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_contacts';
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
            'text' => 'Text',
        ];
    }


    public function getBackground() {
        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->thread_id, 'table' => $this->tableName(), 'key' => 'image' ])
            ->one();

        return $result;
    }

    public function getOffices() {


        return $this->hasMany(BOffice::className(), ['thread_id' => 'thread_id']);
    }

}
