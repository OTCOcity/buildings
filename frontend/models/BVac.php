<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_vac".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $text_require
 * @property string $text_respons
 * @property string $text_conditions
 * @property string $text_comment
 * @property integer $visible
 * @property integer $sort
 */
class BVac extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_vac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'visible', 'sort'], 'integer'],
            [['text_require', 'text_respons', 'text_conditions', 'text_comment'], 'required'],
            [['text_require', 'text_respons', 'text_conditions', 'text_comment'], 'string'],
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
            'text_require' => 'Text Require',
            'text_respons' => 'Text Respons',
            'text_conditions' => 'Text Conditions',
            'text_comment' => 'Text Comment',
            'visible' => 'Visible',
            'sort' => 'Sort',
        ];
    }
}
