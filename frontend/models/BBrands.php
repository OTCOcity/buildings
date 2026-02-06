<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_brands".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $url
 * @property integer $image
 */
class BBrands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_brands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'image'], 'integer'],
            [['block_key'], 'string', 'max' => 50],
            [['name', 'url'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'image' => 'Image',
        ];
    }


    public function getLogo() {

        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->id, 'table' => $this->tableName(), 'key' => 'image' ])
            ->one();

        return $result;

    }
}
