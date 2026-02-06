<?php

namespace frontend\models;

use app\models\BGeoItem;
use Yii;

/**
 * This is the model class for table "b_city".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $fullName
 * @property string $code
 * @property string $country
 * @property integer $visible
 */
class BCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'visible'], 'integer'],
            [['block_key'], 'string', 'max' => 50],
            [['name', 'fullName'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 64],
            [['country'], 'string', 'max' => 3],
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
            'fullName' => 'Full Name',
            'code' => 'Code',
            'country' => 'Country',
            'visible' => 'Visible',
        ];
    }


}
