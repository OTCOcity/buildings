<?php

namespace frontend\models;

use app\models\BOsFeedback;

/**
 * This is the model class for table "c_form".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property string $text
 * @property integer $image
 */
class CForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_form';
    }



    public function getFbs() {


        return $this->hasMany(BOsFeedback::className(), ['thread_id' => 'thread_id'])->where(['visible' => 1])->orderBy(['date' => SORT_DESC]);

    }

}
