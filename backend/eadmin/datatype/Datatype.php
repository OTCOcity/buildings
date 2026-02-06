<?php
namespace backend\eadmin\datatype;

use Yii;

/**
 * Config Class
 */
class Datatype
{

    public $model;
    public $config;
    public $form;


    function __construct($model, $config, $form = null)
    {

        $this->model = $model;
        $this->config = $config;
        $this->form = $form;


    }

    public function renderField()
    {

        $dtClass = 'backend\eadmin\datatype\datatypes\DT'.$this->config['type'];
        $dt = new $dtClass($this->model, $this->config, $this->form);


        return $dt->renderField();


    }

    static public function renderListField($type, $value, $config)
    {

        $class = 'backend\eadmin\datatype\datatypes\DT'.$type;
        $result = $class::renderListField($type, $value, $config);


        return $result;

    }



}
