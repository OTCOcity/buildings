<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_options".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $sitename
 * @property string $email
 * @property string $phone
 * @property string $phone_rf
 * @property string $email_rf
 * @property string $phone_kz
 * @property string $email_kz
 * @property string $phone_ekb
 * @property string $email_ekb
 */
class COptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id'], 'integer'],
            [['sitename', 'email', 'phone', 'phone_rf', 'email_rf', 'phone_kz', 'email_kz', 'phone_ekb', 'email_ekb'], 'string', 'max' => 255],
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
            'sitename' => 'Sitename',
            'email' => 'Email',
            'phone' => 'Phone',
            'phone_rf' => 'Phone Rf',
            'email_rf' => 'Email Rf',
            'phone_kz' => 'Phone Kz',
            'email_kz' => 'Email Kz',
            'phone_ekb' => 'Phone Ekb',
            'email_ekb' => 'Email Ekb',
        ];
    }
}
