<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Reg Form
 */
class RegForm extends Model
{
    public $email;
    public $password;
    public $type;


    private $clientThreadId = 45;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email', 'message' => 'Некорректный `email`'],
            ['password', 'passwordCorrect'],
            ['email', 'emailUnique'],
            ['type', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль'
        ];
    }


    public function passwordCorrect($attribute, $params)
    {
        if (!preg_match("/^[0-9A-Za-z]*$/ui", $this->password)) {
            $this->addError($attribute, 'Только латинский алфавит и цифры');
        }
    }

    public function emailUnique($attribute, $params)
    {

        if (BClients::find()->where(['email' => $this->email])->one() !== null) {

            $this->addError($attribute, 'Такой Email уже существует');
        }
    }


    public function registrate() {

        $client = new BClients();

        $client->email = $this->email;
        $client->password = Yii::$app->security->generatePasswordHash($this->password);

        $client->type = (int)$this->type;
        $client->token = Yii::$app->security->generateRandomString();
        $client->thread_id = $this->clientThreadId;

        $client->save(false);


        // Email to user
        $subject = "Регситрация на сайте " . Yii::$app->params['sitename'];
        Yii::$app->mailer->compose('touser/registration.php', ['client' => $client, 'password' => $this->password, 'subject' => $subject])
            ->setFrom(Yii::$app->params['siteRobotEmail'])
            ->setTo($client->email)
            ->setSubject($subject)
            ->send();

        // Email to admin
        $subject = "Новый пользователь на сайте " . Yii::$app->params['sitename'];
        Yii::$app->mailer->compose('toadmin/registration.php', ['client' => $client, 'subject' => $subject])
            ->setFrom(Yii::$app->params['siteRobotEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->send();


        return $client->id;
    }




}
