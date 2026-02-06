<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "c_price".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $image
 * @property integer $file
 * @property string $name
 * @property string $anons
 * @property string $text
 */
class CPrice extends \yii\db\ActiveRecord
{


    public $search = "";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'image', 'file'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['anons'], 'string', 'max' => 1000],
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
            'image' => 'Image',
            'file' => 'File',
            'name' => 'Name',
            'anons' => 'Anons',
            'text' => 'Text',
        ];
    }

    public function getPrice() {


        return $this->hasMany(BPrice::className(), ['thread_id' => 'thread_id']);

    }

    public function getPriceStructure() {


        $priceArr = [];
        $sgIndex = 0;
        $gIndex = 0;

        foreach($this->price as $val) {

//            var_dump ($val->name.$val->group.$val->group);
//            var_dump ($this->search);
//            var_dump (mb_stripos($val->name.$val->group.$val->subgroup.$val->anons, $this->search));
//            var_dump ("----------------");
            if ($this->search && mb_stripos($val->name.$val->group.$val->subgroup.$val->anons, $this->search, null, "utf-8") === false ) continue;

            $groupHash      = md5($val->group);
            $subgroupHash   = md5($val->subgroup);

            if (!isset($priceArr[$groupHash])) {
                $priceArr[$groupHash]['item'] = [];
                $priceArr[$groupHash]['index'] = $gIndex;
                $priceArr[$groupHash]['name'] = $val->group;
                $gIndex = 0;
            }
            if (!isset($priceArr[$groupHash]['item'][$subgroupHash])) {
                $priceArr[$groupHash]['item'][$subgroupHash]['item'] = [];
                $priceArr[$groupHash]['item'][$subgroupHash]['index'] = $sgIndex;
                $priceArr[$groupHash]['item'][$subgroupHash]['name'] = $val->subgroup;
                $sgIndex++;
            }


            // Цены на тару
            $pArr = [];
            foreach (explode("\r\n",$val->price) as $pVal) {
                $pArr[] = explode(";", $pVal);
            }
            $val->pArr = $pArr;

            $priceArr[$groupHash]['item'][$subgroupHash]['item'][] = $val;

        }

        return $priceArr;
    }



    public function getBackground() {
        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->thread_id, 'table' => $this->tableName(), 'key' => 'image' ])
            ->one();

        return $result;
    }

    public function getPricefile() {
        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('file')
            ->where(['item_id' => $this->thread_id, 'table' => $this->tableName(), 'key' => 'file' ])
            ->one();

        return $result;
    }


}
