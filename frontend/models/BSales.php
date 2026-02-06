<?php

namespace frontend\models;

use common\models\Thread;
use Yii;
use frontend\components\MiscFunc;

/**
 * This is the model class for table "b_sales".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property integer $image
 * @property string $name
 * @property string $link
 * @property string $text
 * @property string $date_start
 * @property string $date_finish
 * @property integer $good_list
 */
class BSales extends \yii\db\ActiveRecord
{
    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'image', 'good_list'], 'integer'],
            [['text'], 'string'],
            [['block_key', 'date_start', 'date_finish'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'link' => 'Link',
            'text' => 'Text',
            'date_start' => 'Date Start',
            'date_finish' => 'Date Finish',
            'good_list' => 'Good List',
        ];
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

    public function getPath() {

        return $this->thread->url . "/" . $this->link;
    }


    public function getDaterange() {

        $dayStart = date("j", strtotime($this->date_start));
        $dayFinish = date("j", strtotime($this->date_finish));
        $year = date("Y", strtotime($this->date_finish));
        $monthStart = mb_strtolower(MiscFunc::$monthArr[date("n", strtotime($this->date_start))], "utf-8");
        $monthFinish = mb_strtolower(MiscFunc::$monthArr[date("n", strtotime($this->date_finish))], "utf-8");

        if ($monthStart == $monthFinish) {
            $result = "с {$dayStart} по {$dayFinish} ".$monthStart;
        } else {
            $result = "с {$dayStart} {$monthStart} по {$dayFinish} ".$monthFinish;
        }
        return $result . " " . $year . " г.";
    }
	
    
	public function getDatestr() {
		
		$t = strtotime($this->date);
		
		if ($this->date) {
			return date("j", $t) . " " .mb_strtoupper(MiscFunc::$monthArr[date("n", $t)], "utf-8") . " " . date("Y", $t);
		} else {
			return "&nbsp;";
		}
		
		
		
	}
	
	
    public function getIsactive() {

        $dayStart = strtotime($this->date_start);
        $dayFinish = strtotime($this->date_finish);

        if (($dayStart < time() || empty($this->date_start)) && (time() < $dayFinish || empty($this->date_finish))) {

            return 1;
        } else {

            return 0;
        }

    }


    public function getGoods() {


        return $this->hasMany(BCatalogGoods::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'id'], function($query){
            $query->where(['table' => 'b_sales', 'key' => 'good_list']);
        });

    }

    public function getThreads() {

        return $this->hasMany(Thread::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'id'], function($query){
            $query->where(['table' => 'b_sales', 'key' => 'filter_list']);
        });

    }

    public function getThreadsArr() {

        $result = [];
        foreach ($this->threads as $val) {

            $result[$val->id] = $val->id;
        }

        return $result;
    }


    static public function getFilters($getFilters) {


        $filters = (new \yii\db\Query())
            ->select(['thread.id', 'thread.name'])
            ->from('thread')
            ->innerJoin('relations', "relations.value = thread.id AND relations.table = 'b_sales' AND relations.key = 'filter_list'")
            ->where(['thread.active' => '1'])
            ->orderBy('thread.sort')
            ->groupBy(['thread.sort'])
            ->all();

        foreach ($filters as $key => $val) {
            if (isset($getFilters[(int)$val['id']])) {
                $filters[$key]['checked'] = true;
            }
        }


        return $filters;
    }




}
