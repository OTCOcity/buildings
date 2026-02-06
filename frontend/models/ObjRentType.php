<?php

namespace frontend\models;

/**
 * @property integer $id
 * @property string $name
 */
class ObjRentType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'obj_rent_type';
    }

    public function getObjects() {

        return $this->hasMany(BObject::className(), ['obj_rent_type_id' => 'id']);
    }

    public function getObjectsForMain() {


        return $this->hasMany(BObject::className(), ['obj_rent_type_id' => 'id'])->limit(6);
    }

}
