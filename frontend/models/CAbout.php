<?php

namespace frontend\models;

class CAbout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_about';
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

    public function getImages()
    {

        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('image')
            ->where(['item_id' => $this->thread_id, 'table' => $this->tableName(), 'key' => 'image'])
            ->limit(4)
            ->all();

        return $result;
    }

}
