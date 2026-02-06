<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;

/**
 * Config Class
 */
class DTckeditor extends DT
{



    static public function renderListField($type, $value, $config)
    {

        $value = mb_substr(strip_tags($value), 0, 100);


        return $value;
    }


}
