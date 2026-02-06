<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "b_benefit".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $text
 * @property integer $sort
 * @property integer $visible
 */
class BBenefit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_benefit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'sort', 'visible'], 'integer'],
            [['text', 'sort', 'visible'], 'required'],
            [['text'], 'string'],
            [['block_key'], 'string', 'max' => 50],
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
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'name' => 'Name',
            'text' => 'Text',
            'sort' => 'Sort',
            'visible' => 'Visible',
        ];
    }
}
