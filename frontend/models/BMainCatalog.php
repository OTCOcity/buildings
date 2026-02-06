<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "b_main_catalog".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $image
 * @property string $name
 * @property string $anons
 * @property string $url
 * @property integer $sort
 */
class BMainCatalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_main_catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'sort'], 'integer'],
            [['block_key', 'image'], 'string', 'max' => 50],
            [['name', 'url'], 'string', 'max' => 255],
            [['anons'], 'string', 'max' => 512],
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
            'anons' => 'Anons',
            'url' => 'Url',
            'sort' => 'Sort',
        ];
    }
}
