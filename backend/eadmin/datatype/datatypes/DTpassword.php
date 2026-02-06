<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;

/**
 * Config Class
 */
class DTpassword extends DT
{

    public function renderField()
    {

        $key = $this->config['key'];
        $this->model->$key = "";

        return $this->header() . Yii::$app->view->render("/datatypes/__".$this->config['type'].".twig", ['model' => $this->model, 'config' => $this->config, 'form' => $this->form]);
    }


    static public function beforeSave($value, $config)
    {

        if ($value) {
            return Yii::$app->getSecurity()->generatePasswordHash($value);
        } else {
            return null;
        }
    }


}
