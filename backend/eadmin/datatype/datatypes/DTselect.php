<?php
namespace backend\eadmin\datatype\datatypes;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Config Class
 */
class DTselect extends DT
{

    public function renderField()
    {

        // Варианты выбора из конфига
        $data = [];
        if ($this->config['data']['table']) { // Другая таблица

            $data = (new \yii\db\Query())
                ->select([$this->config['data']['name'] . " as s_name", $this->config['data']['value']])
                ->from($this->config['data']['table'])
                ->where($this->config['data']['where'])
                ->all();


            $data = ArrayHelper::map($data, 'id', 's_name');



        } elseif ($this->config['data']['values']) { // Массив

            $data = $this->config['data']['values'];
        }



        $key = $this->config['key'];
        $this->model->$key = $this->config['_value'];

        return Yii::$app->view->render("/datatypes/__select.twig", ['model' => $this->model, 'config' => $this->config, 'form' => $this->form, 'data' => $data]);
    }

    static public function renderListField($type, $value, $config)
    {

        if (isset($config['data']['values'][$value])) {

            $value = $config['data']['values'][$value];
        }

        if ($config['data']['table']) {

            $query = new Query();
            $result = $query->select($config['data']['name'])
                ->from($config['data']['table'])
                ->where("`{$config['data']['value']}` = '{$value}'")
                ->one();

            return $result[$config['data']['name']];
        }


        return $value;


    }

}
