<?php
namespace frontend\models\forms;

use app\models\BOsFeedback;
use frontend\components\MiscData;
use Yii;
use yii\base\Model;

/**
 * FeedbackForm Form
 */
class FeedbackForm extends Model
{
    public $name;
    public $company;
    public $city;
    public $email;
    public $theme;
    public $phone;
    public $text;
    public $file;
    public $check;

    public $agree;

    public $uploadFileInstance;


    public function rules()
    {
        return [
            [['name', 'phone', 'text'], 'required'],
//            [['agree'], 'required', 'requiredValue' => 1, 'message' => 'Вы должны согласиться с обработкой персональных данных'],
//            [['phone', 'name', 'city', 'email', 'theme', 'text', 'check'], 'required'],
            [['email'], 'email'],
//            [['company'], 'required'],
//            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, xls, pdf, png, jpg', 'maxSize' => 7 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'name' => 'Ваше имя',
            'company' => 'Компания',
            'city' => 'Город',
            'theme' => 'Тема',
            'email' => 'Email',
            'text' => 'Описание',
            'file' => 'Файл',
            'agree' => 'Согласие на обработку персональных данных'
        ];
    }


    public function send() {

        $options = MiscData::getDbData('c_options');

        // Email to admin
        $subject = "Письмо на сайте " . Yii::$app->params['sitename'];
        Yii::$app->mailer->compose('toadmin/feedback.php', ['form' => $this, 'subject' => $subject])
            ->setFrom(Yii::$app->params['siteRobotEmail'])
            ->setTo($options[0]['email'] ? $options[0]['email'] : Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->send();

    }

    public function save() {

        $fb = new BOsFeedback();
        $fb->thread_id = Yii::$app->params['fbThreadId'];
        $fb->block_id = 0;
        $fb->name = $this->name;
        $fb->phone = $this->phone;
        $fb->text = $this->text;
        $fb->date = time();
        $fb->visible = 1;
        $fb->lang = 'ru';
        $fb->save(false);
        $fb->source_id = $fb->id;
        $fb->save(false);



    }

    public function uploadFile()
    {

        $uid = uniqid(time(), true);
        $fileSrc = $uid . '.' . $this->uploadFileInstance->extension;

        if ($this->validate() && $this->uploadFileInstance) {

            $this->uploadFileInstance->saveAs('upload/orig/' . $fileSrc);
            return $fileSrc;
        } else {

            return false;
        }
    }

}
