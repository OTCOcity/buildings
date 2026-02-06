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
class BTech extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_standart_tech';
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


    /** BSubStandart rel */
    public function getSubStandart() {
        return $this->hasOne(BSubStandart::className(), ['id' => 'block_id']);
    }


    /** Youtube video id */
    public function getVideoId() {

        $vid = "GU18V_BnE1I";

        return $vid;
    }



}
