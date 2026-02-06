<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_comments".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property integer $user_id
 * @property string $date
 * @property string $text
 * @property double $rating
 */
class BComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['rating'], 'number'],
            [['block_key', 'date'], 'string', 'max' => 50],
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
            'user_id' => 'User ID',
            'date' => 'Date',
            'text' => 'Text',
            'rating' => 'Rating',
        ];
    }
}
