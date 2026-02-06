<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_colors".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $color
 */
class BColors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_colors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id'], 'integer'],
            [['block_key', 'color'], 'string', 'max' => 50],
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
            'color' => 'Color',
        ];
    }
}
