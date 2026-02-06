<?php

namespace frontend\models;

use app\models\BBenefit;
use common\models\Thread;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "c_catalog_group".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $image
 * @property integer $bg
 * @property string $name
 * @property string $text
 */
class CCatalogGroup extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_catalog_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'image', 'bg'], 'integer'],
            [['text'], 'string'],
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
            'image' => 'Image',
            'name' => 'Name',
            'text' => 'Text',
        ];
    }


    /**
     * Вложенные группы
     * @return array
     */
    public function getGroups()
    {

        $rows = (new \yii\db\Query())
        ->select('*')
        ->from('c_catalog_group')
        ->innerJoin('thread', 'c_catalog_group.thread_id = thread.id')
        ->where(['thread.active' => '1', 'thread.parent' => $this->thread_id])
        ->orderBy('thread.sort')
        ->all();

        return $rows;

//        return $this->hasMany(CCatalogGroup::className(), ['thread_id' => 'id'])->viaTable('thread', ['parent' => 'thread_id'], function($query){
//            $query->where(['active' => 1]);
//        });
    }


    /**
     * Вложенные товары
     * @return array
     */
    public function getGoods()
    {

        return $this->hasMany(BCatalogGoods::className(), ['thread_id' => 'thread_id'])->where(['visible' => 1])->orderBy('sort');
    }

    /**
     * Реклама
     * @return array of models
     */
    public function getAdvs() {


        return $this->hasMany(BAdv::className(), ['id' => 'item_id'])->viaTable('relations', ['value' => 'thread_id'], function($query){
            $query->where(['table' => 'b_adv', 'key' => 'groups']);
        })->where(['visible' => 1])->orderBy('sort');
    }

    /**
     * Выгода
     * @return $this
     */
    public function getBenefits() {

        return $this->hasMany(BBenefit::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'thread_id'], function($query){
            $query->where(['table' => 'c_catalog_group', 'key' => 'benefit']);
        })->where(['visible' => 1])->orderBy('sort');

    }

    /**
     * Спецпредложения
     * @return $this
     */
    public function getSales() {

        return $this->hasMany(BSales::className(), ['id' => 'item_id'])->viaTable('relations', ['value' => 'thread_id'], function($query){
            $query->where(['table' => 'b_sales', 'key' => 'group_list']);
        })->orderBy('sort');

    }
    /**
     * Активные Спецпредложения
     * @return $this
     */
    // public function getActiveSales() {

        // return $this->hasMany(BSales::className(), ['id' => 'item_id'])->viaTable('relations', ['value' => 'thread_id'], function($query){
            // $query->where(['table' => 'b_sales', 'key' => 'group_list']);
        // })->where(['>', "STR_TO_DATE(date_finish,'%d.%m.%Y')", 'UNIX_TIMESTAMP(NOW())'])->andWhere(['<', "STR_TO_DATE(date_start,'%d.%m.%Y')", 'UNIX_TIMESTAMP(NOW())'])->orderBy('sort');

    // }

    /**
     * @return object инфа раздела
     */
    public function getThread()
    {

        if (!$this->_thread->id) {

            $this->_thread = Thread::findOne($this->thread_id);
        }

        return $this->_thread;
    }

    public function getName()
    {

        return $this->thread->name;
    }
    public function getNameBr()
    {

        $nameArr = explode(" ", $this->thread->name);

        // return implode("<br>", $nameArr);
        return $this->thread->name;
    }

    public function getUrl()
    {

        return $this->thread->url;
    }


    /**
     * Сопутствующие товары
     * @return $this
     */
    public function getSimilars() {

        return $this->hasMany(BCatalogGoods::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'thread_id'], function($query){
            $query->where(['table' => 'c_catalog_group', 'key' => 'similar_goods']);
        });

    }

    /**
     * Сопутствующие группы
     * @return $this
     */
    public function getSimilarGroups() {

        return $this->hasMany(CCatalogGroup::className(), ['thread_id' => 'value'])->viaTable('relations', ['item_id' => 'thread_id'], function($query){
            $query->where(['table' => 'c_catalog_group', 'key' => 'similar_groups']);
        });

    }
	
	
	public function getIsgood() {
		return false;
	}

}