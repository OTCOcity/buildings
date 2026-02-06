<?php

namespace frontend\models;

/**
 * @property integer $id
 * @property string $name
 */
class ObjType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'obj_type';
    }


}
