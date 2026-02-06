<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "b_geo_item".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $image
 * @property string $name
 * @property string $text
 * @property string $url
 * @property integer $visible
 */
class BGeoItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_geo_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'visible'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['block_key'], 'string', 'max' => 50],
            [['image', 'name', 'url'], 'string', 'max' => 255],
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
            'image' => 'Image',
            'name' => 'Name',
            'text' => 'Text',
            'url' => 'Url',
            'visible' => 'Visible',
        ];
    }
}
