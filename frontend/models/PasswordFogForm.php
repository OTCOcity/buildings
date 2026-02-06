<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * PasswordFog form
 */
class PasswordFogForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email', 'message' => 'Некорректный `email`'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }


    public function newPassword() {

        $client = BClients::findByEmail($this->email);

        if ($client !== null) {

            $password = Yii::$app->security->generateRandomString(6);

            $client->password = Yii::$app->security->generatePasswordHash($password);

            $client->save(false);

            // Email to user
            $subject = "Изменение пароля на сатйе " . Yii::$app->params['sitename'];
            Yii::$app->mailer->compose('touser/passwordFog.php', ['password' => $password, 'client' => $client, 'subject' => $subject])
                ->setFrom(Yii::$app->params['siteRobotEmail'])
                ->setTo($client->email)
                ->setSubject($subject)
                ->send();


        }


    }




}
