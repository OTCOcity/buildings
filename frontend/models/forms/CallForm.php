<?php
namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * Call Form
 */
class CallForm extends Model
{
    public $name;
    public $phone;
    public $check;


    public function rules()
    {
        return [
            [['phone', 'name', 'check'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'name' => 'Ваше имя',
	        'check' => 'Согласие'
        ];
    }


    public function send() {


//        // Email to admin
//        $subject = "Письмо на сайте " . Yii::$app->params['sitename'];
//        Yii::$app->mailer->compose('toadmin/feedback.php', ['form' => $this, 'subject' => $subject])
//            ->setFrom(Yii::$app->params['siteRobotEmail'])
//            ->setTo(Yii::$app->params['adminEmail'])
//            ->setSubject($subject)
//            ->send();
//




    }



}
