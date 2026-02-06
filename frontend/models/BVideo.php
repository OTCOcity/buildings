<?php

namespace frontend\models;

use backend\eadmin\config\Config;
use common\models\Thread;
use Yii;

/**
 * This is the model class for table "b_video".
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
 * @property array $creditsArr
 * @property array $imageAwards
 * @property array $imageSelections
 * @property array $imageScreenshots
 *
 * @property BVideo $source
 * @property BVideo $langData
 */
class BVideo extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_video';
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
    public function getThread()
    {

        if (!$this->_thread->id) {
            $this->_thread = Thread::findOne($this->thread_id);
        }

        return $this->_thread;
    }

    public function getPath()
    {

        return $this->thread->url . "/" . $this->source->link;
    }

    public function getSource()
    {
        return $this->hasOne(BVideo::className(), ['id' => 'source_id']);
    }


    public function getUrl()
    {

        return $this->thread->url . "/" . $this->link;
    }


    public function getLangData()
    {

        $modelDefault = $this->source;
        $modelLang = self::find()->where(['source_id' => $modelDefault->id, 'lang' => Yii::$app->language])->one();

        $config = Config::getConfig('video', true);
        foreach ($config['tabs'] as $tab) {
            foreach ($tab['fields'] as $field) {
                if ($field['lang']) {
                    $key = $field['key'];
                    $modelDefault->$key = $modelLang->$key;
                }
            }
        }

        $modelDefault->id = $modelLang->id;
        if ($modelDefault->hasAttribute('seo_title')) $modelDefault->seo_title = $modelLang->seo_title;
        if ($modelDefault->hasAttribute('seo_description')) $modelDefault->seo_description = $modelLang->seo_description;
        if ($modelDefault->hasAttribute('seo_keywords')) $modelDefault->seo_keywords = $modelLang->seo_keywords;

        return $modelDefault;

    }


    public function getVideoId()
    {
        preg_match("/\d{7,20}/ui", $this->video_url, $matches);
        return $matches[0];
    }

    public function getCreditsArr()
    {

        $result = [];
        $rows = explode("\r\n", $this->credits);
        foreach ($rows as $row) {
            $credit = explode(":", $row);
            $result[] = [
                'post' => trim($credit[0]),
                'name' => trim($credit[1]),
            ];
        }

        return $result;

    }

    public function getNextVideo()
    {

        /** @var BVideo $video */
        $video = BVideo::find()
            ->where(['thread_id' => $this->thread_id])
            ->andWhere(['<>', 'source_id', $this->source_id])
            ->andWhere(['>=', 'sort', $this->sort])
            ->one();

        return $video->langData;
    }

    public function getImageAwards()
    {
        return $this->hasMany(Image::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' => 'image_awards'])->orderBy('id');
    }

    public function getImageSelections()
    {
        return $this->hasMany(Image::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' => 'image_selections'])->orderBy('id');
    }

    public function getImageScreenshots()
    {
        return $this->hasMany(Image::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' => 'image_screenshots'])->orderBy('id');
    }

    public function getAwwardsCount() {
        return $this->getImageAwards()->count();
    }

}
