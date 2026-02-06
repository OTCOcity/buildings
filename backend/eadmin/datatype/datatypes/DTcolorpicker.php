<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;

/**
 * Config Class
 */
class DTcolorpicker extends DT
{


    static public function renderListField($type, $value)
    {

        $value = "<div style='background: {$value}; width: 35px; box-shadow: 0 0 5px rgba(0,0,0,0.25);'>&nbsp;</div>";


        return $value;
    }




}
