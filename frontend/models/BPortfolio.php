<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_portfolio".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property integer $image
 * @property string $name
 * @property string $link
 * @property string $anons
 * @property string $text
 */
class BPortfolio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_portfolio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'image'], 'integer'],
            [['text'], 'string'],
            [['block_key'], 'string', 'max' => 50],
            [['name', 'link'], 'string', 'max' => 255],
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
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'image' => 'Image',
            'name' => 'Name',
            'link' => 'Link',
            'anons' => 'Anons',
            'text' => 'Text',
        ];
    }
}
