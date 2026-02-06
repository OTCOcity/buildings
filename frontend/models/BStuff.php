<?php

namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "b_stuff".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $email
 * @property integer $type
 * @property string $name
**/
class BStuff extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_stuff';
    }




}
