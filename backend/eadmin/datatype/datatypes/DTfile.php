<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;
use yii\base\DynamicModel;

/**
 * Config Class
 */
class DTfile extends DT
{

    public function renderField()
    {

        $data = $this->config['_value'];

        $model = new DynamicModel([$this->config['key'], 'structureType']);
        $model->structureType = $this->model->structureType;

        return $this->header() . Yii::$app->view->render("/datatypes/__file.twig", ['model' => $model, 'config' => $this->config, 'form' => $this->form, 'data' => $data]);
    }

    static public function beforeSave($value, $config)
    {

        if ($value === null) {
            return "";
        } else {
            return $value;
        }
    }



}
