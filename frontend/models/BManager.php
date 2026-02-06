<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_manager".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $image
 * @property string $name
 * @property string $phone
 * @property string $text
 */
class BManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id'], 'integer'],
            [['phone', 'text'], 'string'],
            [['block_key', 'image'], 'string', 'max' => 50],
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
            'image' => 'Image',
            'name' => 'Name',
            'phone' => 'Phone',
            'text' => 'Text',
        ];
    }


    public function getPhones()
    {

        $result = [];
        foreach(explode("\r\n", $this->phone) as $val) {

            $phoneArr = explode(":", $val);

            $result[] = (object)[
                'name' => trim($phoneArr[0]),
                'value' => trim($phoneArr[1]),
            ];

        }


        return $result;
    }
}
