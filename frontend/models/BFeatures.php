<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_features".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $main_image
 * @property string $name
 * @property string $link
 * @property string $text
 * @property string $date
 * @property integer $checkbox
 * @property integer $select
 */
class BFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'checkbox', 'select'], 'integer'],
            [['block_key'], 'required'],
            [['text'], 'string'],
            [['block_key', 'main_image', 'date'], 'string', 'max' => 50],
            [['name', 'link'], 'string', 'max' => 255],
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
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'main_image' => 'Main Image',
            'name' => 'Name',
            'link' => 'Link',
            'text' => 'Text',
            'date' => 'Date',
            'checkbox' => 'Checkbox',
            'select' => 'Select',
        ];
    }

    public function getImage() {

        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->id, 'table' => $this->tableName(), 'key' => 'main_image' ])
            ->one();

        return $result;

    }


}
