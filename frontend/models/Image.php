<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $table
 * @property string $key
 * @property integer $item_id
 * @property string $file
 * @property string $name
 * @property string $desc
 * @property integer $sort
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table', 'key', 'name', 'desc'], 'required'],
            [['item_id', 'sort'], 'integer'],
            [['desc'], 'string'],
            [['table', 'key', 'file', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table' => 'Table',
            'key' => 'Key',
            'item_id' => 'Item ID',
            'file' => 'File',
            'name' => 'Name',
            'desc' => 'Desc',
            'sort' => 'Sort',
        ];
    }
}
