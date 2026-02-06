<?php

namespace frontend\models;

use frontend\components\MiscBlocks;
use frontend\components\MiscFunc;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $name
 */
class CStandart extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_standart';
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

    public function getStandarts() {


        return $this->hasMany(BStandart::className(), ['thread_id' => 'thread_id'])->where(['visible' => 1])->orderBy('sort, id');

    }




}
