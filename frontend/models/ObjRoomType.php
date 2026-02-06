<?php

namespace frontend\models;

/**
 * @property integer $id
 * @property string $name
 */
class ObjRoomType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'obj_room_type';
    }


}
