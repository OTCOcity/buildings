<?php

namespace frontend\models;

/**
 * This is the model class for table "c_object".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $image
 * @property string $name
 * @property string $text
 */
class CObject extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_object';
    }



}
