<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "b_clients".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $email
 * @property integer $type
 * @property string $name
 * @property string $sirname
 * @property string $midname
 * @property string $phone
 * @property string $password
 * @property string $file_rek
 * @property string $file_dog
 * @property string $sob
 * @property string $company
 * @property string $ogrn
 * @property string $kpp
 * @property string $inn
 * @property string $bik
 * @property string $rs
 * @property string $ks
 * @property string $ur_adres
 * @property string $token
 * @property string $fullName
 */
class BClients extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'type'], 'integer'],
            [['block_key'], 'string', 'max' => 50],
            [['email', 'name', 'sirname', 'midname', 'phone', 'password', 'file_rek', 'file_dog', 'sob', 'company', 'ogrn', 'kpp', 'inn', 'bik', 'rs', 'ks'], 'string', 'max' => 255],
            [['ur_adres'], 'string', 'max' => 1000],
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
            'email' => 'Email',
            'type' => 'Type',
            'name' => 'Name',
            'sirname' => 'Sirname',
            'midname' => 'Midname',
            'phone' => 'Phone',
            'password' => 'Password',
            'file_rek' => 'File Rek',
            'file_dog' => 'File Dog',
            'sob' => 'Sob',
            'company' => 'Company',
            'ogrn' => 'Ogrn',
            'kpp' => 'Kpp',
            'inn' => 'Inn',
            'bik' => 'Bik',
            'rs' => 'Rs',
            'ks' => 'Ks',
            'ur_adres' => 'Ur Adres',
        ];
    }




    static public function findByEmail($email) {

        return BClients::find()->where(['email' => $email])->one();
    }



    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {

        return static::findOne(['id' => $id]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * Генерирует ссылку для активации аккаунта
     * @return bool|string
     */
    public function getActivateUrl() {
        if ($this->token) {
            return trim(Yii::$app->params['siteurl'], "/")."/cabinet/activate/{$this->id}/{$this->token}";
        } else {
            return false;
        }
    }



    public function getTypeStr() {

        return $this->type ? "Юридическое лицо" : "Физическое лицо";
    }


    public function getFullName() {


        return $this->sirname." ".$this->name." ".$this->midname;
    }

    public function getShortName() {


        return ($this->name ? mb_substr($this->name,0,1).". " : "") . ($this->midname ? mb_substr($this->midname,0,1) . ". " : "") . $this->sirname;
    }



}
