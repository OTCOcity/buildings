<?php

namespace frontend\models;

use common\models\Thread;
use Yii;

/**
 * This is the model class for table "b_news".
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
 *
 * @property BNews $source
 */
class BNews extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'checkbox', 'select'], 'integer'],
            [['block_key'], 'required'],
            [['text'], 'string'],
            [['block_key', 'main_image', 'date'], 'string', 'max' => 50],
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
            'main_image' => 'Main Image',
            'name' => 'Name',
            'link' => 'Link',
            'text' => 'Text',
            'date' => 'Date',
            'checkbox' => 'Checkbox',
            'select' => 'Select',
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

        return $this->thread->url . "/" . $this->source->link;
    }

    public function getSource() {
        return $this->hasOne(BNews::className(), ['id' => 'source_id']);
    }


    public function getUrl() {

        return $this->thread->url . "/" . $this->link;
    }


}
