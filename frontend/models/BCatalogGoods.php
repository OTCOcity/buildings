<?php

namespace frontend\models;

use app\models\BBenefit;
use backend\eadmin\config\Config;
use backend\models\Relations;
use common\models\Thread;
use frontend\components\MiscFunc;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "b_catalog_goods".
 *
 * @property integer $id
 * @property integer $weight
 * @property integer $volume
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $image
 * @property string $file
 * @property string $name
 * @property string $link
 * @property string $text
 * @property string $date
 * @property integer $opt_colors
 * @property integer $opt_iznos
 * @property integer $opt_3in1
 * @property integer $opt_minus
 * @property integer $group_list
 */
class BCatalogGoods extends \yii\db\ActiveRecord
{

    static public $pageLimit = 1;

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_catalog_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'opt_colors', 'opt_iznos', 'opt_3in1', 'opt_minus', 'group_list'], 'integer'],
            [['block_key'], 'required'],
            [['text'], 'string'],
            [['block_key', 'image', 'file', 'date'], 'string', 'max' => 50],
            [['name', 'link'], 'string', 'max' => 255],
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
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'image' => 'Image',
            'file' => 'File',
            'name' => 'Name',
            'link' => 'Link',
            'text' => 'Text',
            'date' => 'Date',
            'opt_colors' => 'Opt Colors',
            'opt_iznos' => 'Opt Iznos',
            'opt_3in1' => 'Opt 3in1',
            'opt_minus' => 'Opt Minus',
            'group_list' => 'Group List',
        ];
    }


    /**
     * Цена на товар
     * @return float
     */
    public function getCartPrice() {

        return MiscFunc::smartStrToPrice($this->price);
    }


    /**
     * Родительский раздел
     * @return Thread
     */
    public function getThread() {

        if (!$this->_thread->id) {
            $this->_thread = Thread::findOne($this->thread_id);
        }

        return $this->_thread;
    }

    public function getUrl() {

        return $this->thread->url . "/" . $this->link;
    }

    public function getLvl() {

        return $this->thread->lvl + 1;
    }


    public function getMainImage() {

        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->id, 'table' => $this->tableName(), 'key' => 'image' ])
            ->one();

        return $result->file;

    }
    public function getImages() {

        return $this->hasMany(Image::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' =>  'galary_image'])->orderBy('id');

    }

    public function getSertificates() {

        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->id, 'table' => $this->tableName(), 'key' => 'sert_image' ])
            ->all();

        return $result;

    }


    public function getSizes() {

        $sizeArr = [];

        $config = Config::getConfig('catalog_goods', true, 'size');
        foreach (Relations::find()->select('value')->where(['item_id' => $this->id, 'key' => 'size', 'table' => 'b_catalog_goods'])->all() as $size) {
            if (isset($config['data']['values'][$size->value])) {
                $sizeArr[] = $config['data']['values'][$size->value];
            }
        }

        return $sizeArr;
    }

    /**
     * Технические характеристики
     * @return array
     */
    public function getTechnics() {

        $tArr = explode("\r\n", $this->text_tech);
        $result = [];
        foreach ($tArr as $val) {
            if ($val[0] || $val[1]) {
                $result[] = explode(";", $val);
            }
        }

        return $result;

    }


    /**
     * Сопутствующие товары
     * @return $this
     */
    public function getSimilars() {

        return $this->hasMany(BCatalogGoods::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'id'], function($query){
            $query->where(['table' => 'b_catalog_goods', 'key' => 'similar_goods']);
        });

    }

    /**
     * Сопутствующие группы
     * @return $this
     */
    public function getSimilarGroups() {

        return $this->hasMany(CCatalogGroup::className(), ['thread_id' => 'value'])->viaTable('relations', ['item_id' => 'id'], function($query){
            $query->where(['table' => 'b_catalog_goods', 'key' => 'similar_groups']);
        });

    }

    /**
     * Выгода
     * @return $this
     */
    public function getBenefits() {

        return $this->hasMany(BBenefit::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'id'], function($query){
            $query->where(['table' => 'b_catalog_goods', 'key' => 'benefit']);
        })->where(['visible' => 1])->orderBy('sort');

    }

    /**
     * Спецпредложения
     * @return $this
     */
    public function getSales() {

        return $this->hasMany(BSales::className(), ['id' => 'item_id'])->viaTable('relations', ['value' => 'id'], function($query){
            $query->where(['table' => 'b_sales', 'key' => 'good_list']);
        })->orderBy('sort');

    }

    /**
     * Активные Спецпредложения
     * @return $this
     */
    // public function getActiveSales() {

        // return $this->hasMany(BSales::className(), ['id' => 'item_id'])->viaTable('relations', ['value' => 'id'], function($query){
            // $query->where(['table' => 'b_sales', 'key' => 'good_list'])->andWhere(['=', "STR_TO_DATE(date_finish,'%d.%m.%Y')", 'UNIX_TIMESTAMP(NOW())']);
        // })->orderBy('sort');

    // }


    /**
     * Варианты товара
     * @return array of models
     */
    public function getVariants() {


        return $this->hasMany(BGoodVariant::className(), ['block_id' => 'id'])->where(['block_key' => 'catalog_goods', 'visible' => 1])->orderBy('sort');
    }

    /**
     * Реклама
     * @return array of models
     */
    public function getAdvs() {


        return $this->hasMany(BAdv::className(), ['id' => 'item_id'])->viaTable('relations', ['value' => 'id'], function($query){
            $query->where(['table' => 'b_adv', 'key' => 'goods']);
        })->where(['visible' => 1])->orderBy('sort');
    }



    /**
     * Находится ли данный товар в корзине
     * @return bool
     */
    public function getIncart() {

        if (!is_array($_SESSION['cart'])) return false;

        foreach ($_SESSION['cart'] as $val) {

            if ($val->good_id == $this->id) {
                return $val->count;
            }
        }
        return false;

    }

	
	public function getIsgood() {
		return true;
	}



	// For filter
    static public function queryFilter(ActiveQuery $query, array $filters) {


        // Страница
        $page = (int)$filters['page'] > 0 ? (int)$filters['page'] : 1;
        $query->limit(self::getPageLimit());
        $query->offset(self::getPageLimit() * ($page - 1));


        // Сортировка по цене
        if (isset($filters['price']) && $filters['price'] == 'up') {
            $query->orderBy('price asc');
        } elseif (isset($filters['price']) && $filters['price'] == 'down') {
            $query->orderBy('price desc');
        }

        // Размер
        if (trim($filters['size']) !== '') {

            $sizeArr = explode(";", $filters['size']);
            $sizeQueryArr = [];
            foreach ($sizeArr as $sizeItem) {

                $sizeItem = trim($sizeItem);
                if ($sizeItem === '') continue;

                $sizeQueryArr[] = $sizeItem;

            }

            if (count($sizeQueryArr)) {

                $query->leftJoin("relations", "relations.key = 'size' AND relations.item_id = b_catalog_goods.id");
                $query->andWhere(['in', 'relations.value', $sizeQueryArr]);
                $query->groupBy('b_catalog_goods.id');

            }
        }

        // Возраст
        if (trim($filters['age']) !== '') {
            $ageArr = explode(";", $filters['age']);
            $ageQueryArr = [];
            foreach ($ageArr as $ageItem) {

                $ageItem = trim($ageItem);
                if ($ageItem === '') continue;

                $ageQueryArr[] = $ageItem;

            }

            if (count($ageQueryArr)) {

                $query->leftJoin("relations ra", "ra.key = 'age' AND ra.item_id = b_catalog_goods.id");
                $query->andWhere(['in', 'ra.value', $ageQueryArr]);
                $query->groupBy('b_catalog_goods.id');

            }
        }

        // Пол
        if (isset($filters['sex'])) {
            $query->andWhere(['IN', 'sex', array_map(function($v) { return $v - 1;}, explode(";", $filters['sex']))]);
        }


//        echo $query->createCommand()->rawSql;
//        die();

        return $query;

    }


    static public function getPageLimit() {

        $pl = MiscFunc::getThreadData('catalog', 'benefit');

        return (int)$pl ? (int)$pl : self::$pageLimit;
    }

}
