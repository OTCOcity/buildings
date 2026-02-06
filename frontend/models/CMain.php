<?php

namespace frontend\models;

/**
 * This is the model class for table "c_main".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $main_image
 * @property string $seo_title
 * @property string $seo_text
 *
 * @property array $works
 */
class CMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'main_image'], 'integer'],
            [['seo_text'], 'string'],
            [['seo_title'], 'string', 'max' => 255],
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
            'main_image' => 'Main Image',
            'seo_title' => 'Seo Title',
            'seo_text' => 'Seo Text',
        ];
    }

    public function getMainImage()
    {

        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->thread_id, 'table' => $this->tableName(), 'key' => 'main_image'])
            ->one();

        return $result;
    }

}
