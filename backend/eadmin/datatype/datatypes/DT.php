<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;

/**
 * Config Class
 */
class DT
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




        return $this->header() . Yii::$app->view->render("/datatypes/__".$this->config['type'].".twig", ['model' => $this->model, 'config' => $this->config, 'form' => $this->form]);
    }


    static public function renderListField($type, $value, $config)
    {


        return $value;


    }


    static public function beforeSave($value, $config)
    {

        return $value;
    }


        public function header() {

        // Заголовок
        $header = "";
        if ($this->config['header']) {
            $header = Yii::$app->view->render("/datatypes/__fld_header.twig", ['config' => $this->config]);
        }
        return $header;
    }

}
