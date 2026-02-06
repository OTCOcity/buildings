<?php

namespace frontend\models;

/**
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $size
 * @property integer $sort
 */
class FilterSize extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'filter_size';
    }

}
