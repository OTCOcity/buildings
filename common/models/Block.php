<?php

namespace common\models;

use yii\base\Object;

class Block extends Object
{

    public $id;
    public $thread_id = 0;
    public $block_id = 0;
    public $block_key = '';
    public $table = '';
    public $name;

    public function getParentObj() {
        if ($this->thread_id) {
            return Thread::findOne($this->thread_id);
        }

        if ($this->block_id && $this->block_key) {

            return self::getBlockByParams($this->block_id, $this->block_key);
        }

    }

    static public function getBlockByParams($id, $key) {

        $row = (new \yii\db\Query())
            ->select(['id', 'thread_id', 'block_id', 'block_key', 'name'])
            ->from('b_' . $key)
            ->where(['id' => $id])
            ->one();

        $block = new Block();
        $block->id = $row['id'];
        $block->thread_id = $row['thread_id'];
        $block->block_id = $row['block_id'];
        $block->block_key = $row['block_key'];
        $block->name = $row['name'];
        $block->table = $key;

        return $block;
    }
}
