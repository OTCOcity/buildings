<?php

namespace frontend\models\forms;

use frontend\models\crm\Client;
use Yii;
use yii\base\Model;

/**
 * Login Form
 */
class LoginForm extends Model
{
    public $login;
    public $password;

    public $_user;


    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин или телефон',
            'password' => 'Пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)
            ) {
                $this->addError($attribute, 'Неверный логин или пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $login = Yii::$app->user->login($this->getUser(), 86400);

            return $login;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Client|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Client::findByLoginOrPhone($this->login);
        }

        return $this->_user;
    }

}
