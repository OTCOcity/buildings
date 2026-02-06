<?php

namespace frontend\models;

use common\models\Thread;

/**
 * This is the model class for table "b_work_blocks".
 *
 * @property integer $id
 * @property integer $source_id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $image
 * @property string $text
 * @property string $name
 * @property string $type
 * @property string $stuff_id
 * @property string $tab_one_name
 * @property string $tab_one_text
 * @property string $tab_two_name
 * @property string $tab_two_text
 * @property string $tab_three_name
 * @property string $tab_three_text
 * @property string $tab_four_name
 * @property string $tab_four_text
 * @property string $visible
 * @property integer $sort
 * @property string $vimeo
 *
 * @property BStuff $blockQuotAuthor
 * @property array $tabs
 */
class BWorkBlock extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_work_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    }

    public function getBlockQuotAuthor() {

        return $this->hasOne(BStuff::className(), ['id' => 'stuff_id']);
    }

    public function getTabs() {

        $result = [];

        if ($this->tab_one_name) $result[] = ['title' => $this->tab_one_name, 'text' => $this->tab_one_text];
        if ($this->tab_two_name) $result[] = ['title' => $this->tab_two_name, 'text' => $this->tab_two_text];
        if ($this->tab_three_name) $result[] = ['title' => $this->tab_three_name, 'text' => $this->tab_three_text];
        if ($this->tab_four_name) $result[] = ['title' => $this->tab_four_name, 'text' => $this->tab_four_text];

        return $result;
    }

    public function getImages() {
        return $this->hasMany(Image::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' =>  'image'])->orderBy('id');
    }
}
