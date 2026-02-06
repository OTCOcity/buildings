<?php

namespace frontend\models;

use Yii;
use yii\web\Session;

/**
 * This is the model class for table "c_compare".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 */
class CCompare extends \yii\db\ActiveRecord
{


    private $_items;
    private $_activeItems;
    private $_options;
    private $_types;
    private $_activeType = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_compare';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thread_id' => 'Thread ID',
            'name' => 'Name',
        ];
    }

    /**
     * Массив моделей товаров в сравнении
     * @return array
     */
    public function getItems() {

        if ($this->_items) return $this->_items;

        $session = new Session();
        $session->open();

        $compare = $session->get('compare');
        if (!is_array($compare)) $compare = [];

        $items = [];
        foreach($compare as $item) {

            $good = BCatalogGoods::findOne($item);

            $items[] = $good;

        }

        $this->_items = $items;

        return $items;
    }

    /**
     * Массив моделей товаров в сравнении (с учетом активной вкладки)
     * @return array
     */
    public function getActiveItems() {

        if ($this->_activeItems) return $this->_activeItems;

        $items = [];
        foreach ($this->items as $item) {
            if ($item->goodtype->id == $this->activeType) {
                $items[] = $item;
            }
        }

        $this->_activeItems = $items;

        return $items;
    }

    /**
     * Все параметры товаров в сравнении
     * @return array
     */
    public function getOptions() {
        if ($this->_options) return $this->_options;

        $itemsValuesEmptyVal = [];
        foreach ($this->activeItems as $item) {
            $itemsValuesEmptyVal[$item->id] = "";
        }

        $options = [];
        foreach ($this->activeItems as $item) {
            foreach (explode("\r\n", $item->text_tech) as $itemRow) {

                $valArr = explode(";", $itemRow);

                $valArr[0] = trim($valArr[0]);
                $valArr[1] = trim($valArr[1]);

                if (!$valArr[0]) continue;

                $hash = md5($valArr[0]);
                if (!isset($options[$hash])) {

                    $options[$hash] = (object)[
                        'name' => $valArr[0],
                        'values' => $itemsValuesEmptyVal,
                    ];
                }

                $options[$hash]->values[$item->id] = $valArr[1];
            }



        }

        $this->_items = $options;
        return $options;
    }

    /**
     * Все типы товаров в сранении
     * @return array
     */
    public function getTypes() {
        if ($this->_types) return $this->_types;


        $types = [];
        foreach ($this->items as $item) {

            if (!is_numeric($this->activeType)) $this->activeType = $item->goodtype->id;
            $types[$item->type] = $item->goodtype;

        }


        $this->_types = $types;
        return $types;
    }


    /**
     * Get activetype
     * @return int
     */
    public function getActiveType() {

        if (!$this->_activeType) {

            $this->activeType = 0;
        }

        return $this->_activeType;

    }
    /**
     * Set activetype
     * При нуле берет первую группу
     * @return int
     */
    public function setActiveType($value) {


        if (!is_null($value)) {

            $this->_activeType = (int)$value;
        } else {

            $items = $this->items;
            $this->_activeType = $items[0]->goodtype->id ? (int)$items[0]->goodtype->id : 0;
        }


    }









    /**
     * Добавление товара в сравнение
     * @id - id BCatalogGood
     * @param $params
     */
    static function additem($params) {

        $id = (int)$params[1];

        if ($good = BCatalogGoods::findOne($id) === null) die();

        $session = new Session();
        $session->open();

        $compare = $session->get('compare', []);
        if (!is_array($compare)) $compare = [];
        $compare[$id] = $id;

        $session->set('compare', $compare);

    }

    /**
     * Удаление товара из сравнения
     * @id - id BCatalogGood
     * @param $params
     */
    static function removeitem($params) {

        $id = (int)$params[1];

        $session = new Session();
        $session->open();

        $compare = $session->get('compare', []);
        if (!is_array($compare)) $compare = [];
        unset($compare[$id]);

        $session->set('compare', $compare);

        print_r($compare);
    }



}
