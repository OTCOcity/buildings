<?php

namespace frontend\models;

use common\models\Thread;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $main_image
 * @property string $name
 * @property string $link
 * @property string $text
 * @property string $date
 * @property integer $checkbox
 * @property integer $select
 */
class BSubStandart extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_sub_standart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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

    /** BStandart rel */
    public function getStandart() {
        return $this->hasOne(BStandart::className(), ['id' => 'block_id']);
    }

    /** BTechs rel */
    public function getTechs() {
        return $this->hasMany(BTech::className(), ['block_id' => 'id'])->where(['visible' => 1, 'block_key' => 'sub_standart'])->orderBy('sort, id');
    }


    /** BTechs rel */
    public function getExtraSchemas() {
        return $this->hasMany(BExtraSchema::className(), ['block_id' => 'id'])->where(['visible' => 1, 'block_key' => 'sub_standart'])->orderBy('sort, id');
    }

}
