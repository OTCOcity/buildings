<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;

/**
 * Config Class
 */
class DTcheckbox extends DT
{
    static public function renderListField($type, $value) {

        return $value ? "Да" : "Нет";
    }

}
