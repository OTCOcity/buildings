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
class BStandart extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_standart';
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

        return $this->thread->url . "/" . $this->link;
    }


    /** BCalendar rel */
    public function getCalendars() {
        return $this->hasMany(BCalendar::className(), ['block_id' => 'id'])->where(['visible' => 1, 'block_key' => 'standart', 'visible' => 1])->orderBy('sort, id');
    }

    /** BSubStandart rel */
    public function getSubStandarts() {
        return $this->hasMany(BSubStandart::className(), ['block_id' => 'id'])->where(['visible' => 1, 'block_key' => 'standart'])->orderBy('sort, id');
    }

    /** BMore rel */
    public function getMoreStandarts() {
        return BStandart::find()->where(['visible' => 1])->limit(4)->all();
    }

    /** Files rel */
    public function getFiles() {
        return $this->hasMany(File::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' => 'file'])->orderBy('sort, id desc');
    }


    public function getMd5Hash() {

        $data = json_encode($this->attributes);

        foreach ($this->subStandarts as $subStandart) {
            $data .= json_encode($subStandart->attributes);

            foreach ($subStandart->techs as $tech) {
                $data .= json_encode($tech->attributes);
            }
            foreach ($subStandart->extraSchemas as $es) {
                $data .= json_encode($es->attributes);
            }
        }

        foreach ($this->calendars as $c) {
            $data .= json_encode($c->attributes);
        }

        return md5($data);
    }


    public function getPdfFileExists() {

        $pdfDir = Yii::getAlias("@frontend/web/upload/pdf/{$this->id}");

        return file_exists($pdfDir . '/' . $this->md5Hash . '.pdf');


    }


    static public function clearHtmlFromWrongImages($html) {

        if (strlen($html) < 50) return "";

        require_once Yii::getAlias('@frontend/../vendor/simple-html-dom/simple-html-dom/simple_html_dom.php');
        $dom = str_get_html($html);
//        var_dump(strlen($dom->outertext));
        foreach($dom->find('img') as $img) {

            if (!is_file(Yii::getAlias('@frontend/web') . $img->src) && !file_get_contents($img->src)) {
                $img->outertext = '';
                var_dump($img . " - remove");
            } else {
                var_dump($img . " - ok");
            }

        }
//        var_dump(strlen($dom->outertext));

//            echo $element->src . '<br>';
//        var_dump($dom);

        return $dom->outertext;
    }

}
