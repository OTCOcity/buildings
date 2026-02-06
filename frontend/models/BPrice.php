<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_price".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $group
 * @property string $subgroup
 * @property string $name
 * @property string $anons
 * @property string $text
 * @property string $ras
 * @property string $price
 */
class BPrice extends \yii\db\ActiveRecord
{

    public $pArr;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id'], 'integer'],
            [['text', 'price'], 'string'],
            [['block_key'], 'string', 'max' => 50],
            [['group', 'subgroup', 'name', 'ras'], 'string', 'max' => 255],
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
            'group' => 'Group',
            'subgroup' => 'Subgroup',
            'name' => 'Name',
            'anons' => 'Anons',
            'text' => 'Text',
            'ras' => 'Ras',
            'price' => 'Price',
        ];
    }
}
