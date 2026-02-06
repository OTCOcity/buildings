<?php

namespace frontend\models;

/**
 * @property integer $id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $name
 */
class ObjStreet extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'obj_street';
    }


}
