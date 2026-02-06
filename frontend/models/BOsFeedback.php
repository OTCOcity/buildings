<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "b_os_feedback".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $city
 * @property string $company
 * @property string $theme
 * @property string $text
 * @property string $date
 * @property string $lang
 * @property boolean $visible
 * @property integer $source_id
 */
class BOsFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_os_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id'], 'integer'],
            [['block_key'], 'required'],
            [['text'], 'string'],
            [['block_key', 'phone', 'email', 'city', 'date'], 'string', 'max' => 50],
            [['name', 'company', 'theme'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
            'email' => 'Email',
            'city' => 'City',
            'company' => 'Company',
            'theme' => 'Theme',
            'text' => 'Text',
            'date' => 'Date',
        ];
    }
}
