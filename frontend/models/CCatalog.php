<?php

namespace frontend\models;

use app\models\BBenefit;
use common\models\Thread;
use Yii;

/**
 * This is the model class for table "c_catalog".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $image
 * @property string $name
 * @property string $text
 */
class CCatalog extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'image'], 'integer'],
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
     * Устанавливается текущий грод и язык
     */
    static public function setLocation($city, $lang) {


        Yii::$app->location->setCity($city);
        Yii::$app->location->setLang($lang);

        return true;
    }

    /**
     * Выгода
     * @return $this
     */
    public function getBenefits() {

        return $this->hasMany(BBenefit::className(), ['id' => 'value'])->viaTable('relations', ['item_id' => 'id'], function($query){
            $query->where(['table' => 'c_catalog', 'key' => 'benefit']);
        })->where(['visible' => 1])->orderBy('sort');

    }

	public function getIsgood() {
		return false;
	}

}
