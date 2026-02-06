<?php

namespace frontend\models;

/**
 * @property integer $id
 * @property string $name
 */
class ObjCity extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'obj_city';
    }


}
