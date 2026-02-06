<?php

namespace common\models;

use backend\eadmin\config\Config;
use backend\eadmin\config\Language;
use frontend\models\BWork;
use Yii;
use yii\base\Object;
use yii\db\Query;
use yii\web\HttpException;

/**
 * This is the model class for table "thread".
 *
 * @property integer $id
 * @property integer $parent
 * @property integer $module
 * @property string $name
 * @property string $link
 * @property string $url
 * @property integer $active
 * @property integer $inmenu
 * @property integer $sort
 *
 * @property Thread[] $threads
 * @property Object $model
 * @property Object $sourceModel
 */
class Thread extends \yii\db\ActiveRecord
{

    private $_config;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thread';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'module', 'sort', 'inmenu', 'active'], 'integer'],
            [['name', 'sort'], 'required'],
            [['name', 'link'], 'string', 'max' => 255],
            [['link'], 'match', 'pattern' => '/^[a-z0-9\-_]*$/i', 'message' => "Недопустимые символы в ссылке"],
            [['url'], 'string', 'max' => 1000],
            [['module'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module' => 'id']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Thread::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Родительский раздел',
            'module' => 'Тип страницы',
            'name' => 'Название',
            'link' => 'Ссылка',
            'url' => 'Полный путь',
            'active' => 'Доступна на сайте',
            'inmenu' => 'Отображать в меню',
            'sort' => 'Порядковый номер',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleinfo()
    {
        return $this->hasOne(Module::className(), ['id' => 'module']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentthread()
    {
        return $this->hasOne(Thread::className(), ['id' => 'parent']);
    }

    public function getParentObj()
    {
        return $this->hasOne(Thread::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildthreads()
    {

        return $this->hasMany(Thread::className(), ['parent' => 'id'])->where(['active' => 1]);
    }

    public function getChildthreadsAll()
    {

        return $this->hasMany(Thread::className(), ['parent' => 'id']);
    }

    public function getChildMenuthreads()
    {
        return $this->hasMany(Thread::className(), ['parent' => 'id'])->where(['inmenu' => 1, 'active' => 1])->orderBy('sort');
    }


    public function getConfig()
    {

        return Config::getConfig($this->moduleinfo->controller);

    }


    public function getWorkGroups() {

        return (new Query())->select(['group', 'count(*) as cnt'])
            ->from('b_work')
            ->where(['thread_id' => $this->id, 'visible' => 1])
            ->orderBy(['group' => SORT_ASC])
            ->groupBy('group')
            ->all();
    }

    public function getIcon()
    {


        return $this->config['icon'];
    }


    /**
     * Пересчет всех `url` и `lvl` в `thread`
     */
    static function updateTree() {
        $i = 0;
        $threads = Thread::find()->all();
        foreach ($threads as $val) {


            $t = $val;
            $lvl = 0;
            $urlArr = [$val->link];
            while ($pt = $t->parentthread) {


                $lvl++;
                $urlArr[] = $pt->link;


                $t = $pt;


                if ($i++ > 500) die("!");

            }

            $val->lvl = $lvl;
            $val->url = "/".implode("/", array_reverse($urlArr));

            $val->save(false);
        }
    }


    /**
     * Возвращает модель каталога, если есть
     * @return bool
     */
    public function getModel() {

        $result = "c_". $this->config['key'];
        $result = explode("_", $result);
        $class = "";
        foreach ($result as $val) {
            $class .= ucfirst($val);
        }

        $className = "\\frontend\\models\\".$class;


        if  (class_exists($className)) {

            $modelDefault = $className::find()->where(['thread_id' => $this->id, 'lang' => Language::getDefaultLang()])->one();
            $modelLang = $className::find()->where(['thread_id' => $this->id, 'lang' => Yii::$app->language])->one();

//            var_dump($modelDefault);
//            var_dump($modelLang);

            // Объединяем на основе конфига
            foreach ($this->config['tabs'] as $tab) {
                if (is_array($tab['fields'])) {
                    foreach ($tab['fields'] as $field) {
                        $key = $field['key'];
                        if ($field['lang']) {
                            $modelDefault->$key = $modelLang->$key;
                        }
                    }
                }
            }

            $modelDefault['id'] = $modelLang['id'];
            $modelDefault['lang'] = Yii::$app->language;

            if (isset($modelLang['seo_title'])) $modelDefault['seo_title'] = $modelLang['seo_title'];
            if (isset($modelLang['seo_keywords'])) $modelDefault['seo_keywords'] = $modelLang['seo_keywords'];
            if (isset($modelLang['seo_description'])) $modelDefault['seo_description'] = $modelLang['seo_description'];

            return $modelDefault;

        } else {

//            throw new HttpException(404 ,'Отсутствует моедль '.$className);

            return false;
        }

    }

    // Model of main Language
    public function getSourceModel() {

        $result = "c_". $this->config['key'];
        $result = explode("_", $result);
        $class = "";
        foreach ($result as $val) {
            $class .= ucfirst($val);
        }

        $className = "\\frontend\\models\\".$class;


        if  (class_exists($className)) {

            $model = $className::find()->where(['thread_id' => $this->id, 'lang' => Language::getDefaultLang()])->one();


            return $model;

        } else {

//            throw new HttpException(404 ,'Отсутствует моедль '.$className);

            return false;
        }

    }


    public function getBlockList() {

        $blockList = [];
        foreach ($this->config['tabs'] as $tab) {
            if ($tab['inner_blocks']) {
                $blockList[] = (object)[
                  'name' => $tab['name'],
                  'key' => $tab['inner_blocks'],
                ];

            }
        }


        return $blockList;

    }
	
	
	
	
	public function getIsgood() {
		return false;
	}

}
