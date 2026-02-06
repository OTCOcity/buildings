<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_adv".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $image
 * @property string $name
 * @property string $link
 * @property string $html
 * @property integer $visible
 * @property integer $sort
 */
class BAdv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_adv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'visible', 'sort'], 'integer'],
            [['html'], 'required'],
            [['html'], 'string'],
            [['block_key', 'image'], 'string', 'max' => 50],
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
            'image' => 'Image',
            'name' => 'Name',
            'link' => 'Link',
            'html' => 'Html',
            'visible' => 'Visible',
            'sort' => 'Sort',
        ];
    }
}
