<?php

namespace frontend\models;

/**
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $age
 * @property integer $sort
 */
class FilterAge extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'filter_age';
    }

}
