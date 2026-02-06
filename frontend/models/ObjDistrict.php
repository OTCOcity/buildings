<?php

namespace frontend\models;

/**
 * @property integer $id
 * @property integer $city_id
 * @property string $name
 */
class ObjDistrict extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'obj_district';
    }


}
