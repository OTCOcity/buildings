<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;

/**
 * Config Class
 */
class DTdatepicker extends DT
{

    public function renderField()
    {


        // Check fld type - string or int
        if ($this->config['is_int']) {
            $value = $this->config['_value'] ? date('d.m.Y', $this->config['_value']) : 'не задано';
            $this->model[$this->config['key']] = $value;
        }


        return $this->header() . Yii::$app->view->render("/datatypes/__".$this->config['type'].".twig", ['model' => $this->model, 'config' => $this->config, 'form' => $this->form]);
    }

    static public function renderListField($type, $value, $config)
    {


        if ($config['is_int']) {
            return $value ? date("d.m.Y - H:i:s", $value) : 'не задано';
        } else {
            return $value;

        }


    }


    static public function beforeSave($value, $config)
    {

        if ($config['is_int']) {
            $value = strtotime($value);
            if (!$value) $value = 0;
        }

        return $value;
    }

}
