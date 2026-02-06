<?php

namespace backend\models;

use backend\eadmin\config\Language;
use common\models\Thread;
use Yii;
use backend\eadmin\config\Config;
use backend\eadmin\datatype\Datatype;
use yii\helpers\ArrayHelper;


class StructureCat extends StructureItem
{

    static public $prefix = "c_";
    static public $table = "";
    public $config = [];
    private $_fields = [];
    public $threadId = 0;
    public $structureType = "cat";


    function __construct($config)
    {

        $this->config = $config;
        self::$table = $config['key'];

        $this->getFields();


        parent::__construct();
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {

        return self::$prefix . self::$table;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $r = [];
        if (is_array($this->config['tabs'])) {
            foreach ($this->config['tabs'] as $tab) {

                if (is_array($tab['fields'])) {
                    foreach ($tab['fields'] as $field) {

                        if (is_array($field['validate'])) {
                            foreach ($field['validate'] as $val) {

                                $r[] = array_merge([
                                    [$field['key']],
                                    $val['validator'],
                                ], is_array($val['options']) ? $val['options'] : []);

                            }
                        } else {

                            $r[] = [[$field['key']], 'safe'];
                        }
                    }
                }
            }
        }

        return $r;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {

        $al = [];
        if (is_array($this->config['tabs'])) {
            foreach ($this->config['tabs'] as $tab) {

                if (is_array($tab['fields'])) {
                    foreach ($tab['fields'] as $field) {
                        $al[$field['key']] = $field['name'];
                    }
                }
            }
        }

        return $al;
    }


    /**
     * Есть ли seo поля
     * @return bool
     */
    public function getSeo()
    {

        $table = Yii::$app->db->schema->getTableSchema($this->tableName());

        return isset($table->columns['seo_title']) && isset($table->columns['seo_keywords']) && isset($table->columns['seo_description']);
    }


    public function getTabs()
    {

        return $this->config['tabs'];
    }

    /**
     * Список всех полей
     * @return array
     */
    public function getFields()
    {
        if (!is_array($this->_fields) || !count($this->_fields)) {

            $this->_fields = [];
            if (is_array($this->tabs)) {
                foreach ($this->tabs as $key => $tab) {
                    if (is_array($tab['fields'])) {

                        foreach ($tab['fields'] as $tabKey => $field) {

                            $this->_fields[$field['key']] = $field;
                            $this->_fields[$field['key']]['_tab'] = $tabKey;
                        }
                    }


                }
            }


        }

        return $this->_fields;
    }

    public function getInnerCounts()
    {
        if (is_array($this->tabs)) {
            foreach ($this->tabs as $key => $tab) {
                if ($tab['inner_blocks']) {

                    $this->config['tabs'][$key]['_count'] = (new \yii\db\Query())->from('b_' . $tab['inner_blocks'])
                        ->select(['source_id'])
                        ->where(['thread_id' => $this->threadId, 'block_id' => 0])
                        ->groupBy('source_id')
                        ->count();

                }
            }
        }

    }


    public function renderField($key, $form = null)
    {


        $dt = new Datatype($this, $this->fields[$key], $form);


        return $dt->renderField();

    }


    public function renderInnerblocks($key)
    {


        $thread = Thread::findOne($this->threadId);


        $block = new StructureBlock(Config::getConfig($key, true));
        $block->threadId = $thread->id;
        $block->blockId = 0;
        $block->blockKey = "";

        return $block->renderList();

    }


    /**
     * Загрузка всех полей из базы данных по id
     */
    public function loadById($id)
    {


        // Загрузка данных этого языка
        $data = (new \yii\db\Query())
            ->select(['*'])
            ->from($this->tableName())
            ->where(['thread_id' => $id, 'lang' => Language::getLang()])
            ->limit(1)
            ->one();

        // При отсутствии создаем новую запись
        if ($data === false) {

            Yii::$app->db->createCommand()->insert($this->tableName(), [
                'thread_id' => $id,
                'lang' => Language::getLang(),
            ])->execute();

            $data = (new \yii\db\Query())
                ->select(['*'])
                ->from($this->tableName())
                ->where(['thread_id' => $id, 'lang' => Language::getLang()])
                ->limit(1)
                ->one();
        }

        // Загрузка данных дефолтного языка
        if (Language::getLang() !== Language::getDefaultLang()) {
            $dataDefault = (new \yii\db\Query())
                ->select(['*'])
                ->from($this->tableName())
                ->where(['thread_id' => $id, 'lang' => Language::getDefaultLang()])
                ->limit(1)
                ->one();

            // При отсутствии создаем новую запись
            if ($dataDefault === false) {

                Yii::$app->db->createCommand()->insert($this->tableName(), [
                    'thread_id' => $id,
                    'lang' => Language::getDefaultLang(),
                ])->execute();

            }
        } else {
            $dataDefault = $data;
        }

        $this->loadData($data, $dataDefault);

        $this->getInnerCounts();


    }


    public function loadData($data, $dataDefault = [])
    {

        if ($data['id']) { // Загрузка из таблицы


            // Из своей таблицы
            $this->setAttributes($dataDefault, false);
            $this->id = $data['id'];
            if (isset($data['seo_title'])) $this->seo_title = $data['seo_title'];
            if (isset($data['seo_keywords'])) $this->seo_keywords = $data['seo_keywords'];
            if (isset($data['seo_description'])) $this->seo_description = $data['seo_description'];

            foreach ($this->fields as $key => $field) {
                if ($field['lang']) {
                    $this->setAttribute($key, $data[$key], false);
                    $this->_fields[$key]['_value'] = $data[$key];
                } else {
                    $this->_fields[$key]['_value'] = $dataDefault[$key];
                }
            }

//            var_dump($this->attributes);
//            var_dump($data);
//            var_dump($dataDefault);
//            die();

            // Загрузка в _value
//            foreach ($this->_fields as $key => $field) {
//                $this->_fields[$key]['_value'] = $field['lang'] ? $data[$field['key']] : ;
//            }

            // Другие данные
            foreach ($this->fields as $key => $field) {

                // Селекты множественные
                if ($field['type'] == 'select' && $field['multiple']) {

                    $data = (new \yii\db\Query())
                        ->select(['value', 'id'])
                        ->from('relations')
                        ->where([
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->threadId,
                            'lang' => $field['lang'] ? Language::getLang() : Language::getDefaultLang()
                        ])
                        ->all();


                    $this->_fields[$key]['_value'] = ArrayHelper::map($data, 'id', 'value');
                }

                // Изображение
                if ($field['type'] == 'image') {

                    $data = (new \yii\db\Query())
                        ->select(['*'])
                        ->from('image')
                        ->where([
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->threadId,
                            'lang' => $field['lang'] ? Language::getLang() : Language::getDefaultLang()
                        ])
                        ->orderBy('id')
                        ->all();


                    $this->_fields[$key]['_value'] = $data;

                }

                // Файл
                if ($field['type'] == 'file') {

                    $data = (new \yii\db\Query())
                        ->select(['*'])
                        ->from('file')
                        ->where([
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->threadId,
                            'lang' => $field['lang'] ? Language::getLang() : Language::getDefaultLang()
                        ])
                        ->all();


                    $this->_fields[$key]['_value'] = $data;

                }
            }


        } elseif (is_array($data['StructureCat'])) { // Загрузка из пост


            // Загрузка в аттрибуты
            $this->setAttributes($data['StructureCat'], false);

            // Загрузка в _value
            foreach ($this->_fields as $key => $field) {
                $this->_fields[$key]['_value'] = $data['StructureCat'][$field['key']];
            }

        }


    }

    public function saveSeo($post)
    {
        if (isset($post['StructureCat']['seo_title']) && isset($post['StructureCat']['seo_keywords']) && isset($post['StructureCat']['seo_description'])) {
            Yii::$app->db->createCommand()->update($this->tableName(), [
                'seo_title' => $post['StructureCat']['seo_title'],
                'seo_keywords' => $post['StructureCat']['seo_keywords'],
                'seo_description' => $post['StructureCat']['seo_description'],
            ], ['id' => $this->id, 'lang' => Language::getLang()])->execute();

        }
    }


    public function saveData()
    {


        /* Admin config fields */
        foreach ($this->fields as $field) {

            // Сохранение в свою таблицу
            $class = "backend\\eadmin\\datatype\\datatypes\\DT{$field['type']}";

            $saveValue = $class::beforeSave($field['_value'], $field);
            if ($saveValue !== null && ($field['lang'] || Language::getLang() === Language::getDefaultLang())) {

                Yii::$app->db->createCommand()->update($this->tableName(), [

                    $field['key'] => $saveValue,

                ], [
                    'id' => $this->id,
                    'lang' => Language::getLang(),
                ])->execute();

            }


            // Селекты множественные
            if ($field['type'] == 'select' && $field['multiple']) {

                Yii::$app->db->createCommand()->delete('relations', [
                    'table' => $this->tableName(),
                    'key' => $field['key'],
                    'item_id' => $this->threadId,
                    'lang' => Language::getLang(),
                ])->execute();
                if (is_array($field['_value'])) {
                    foreach ($field['_value'] as $value) {
                        Yii::$app->db->createCommand()->insert('relations', [
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->threadId,
                            'value' => $value,
                            'lang' => Language::getLang(),
                        ])->execute();
                    }
                }
            }

            // Изображения
            if ($field['type'] == 'image') {

                Yii::$app->db->createCommand()->delete('image', [
                    'table' => $this->tableName(),
                    'key' => $field['key'],
                    'item_id' => $this->threadId,
                    'lang' => Language::getDefaultLang(),
                ])->execute();
                if (is_array($field['_value'])) {
                    foreach ($field['_value'] as $key => $value) {
                        Yii::$app->db->createCommand()->insert('image', [
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->threadId,
                            'file' => $value,
                            'name' => $_POST['StructureCat'][$field['key'] . '-ownname'][$key],
                            'lang' => Language::getDefaultLang(),
                        ])->execute();
                    }
                }
            }

            // Файлы
            if ($field['type'] == 'file') {

                Yii::$app->db->createCommand()->delete('file', [
                    'table' => $this->tableName(),
                    'key' => $field['key'],
                    'item_id' => $this->threadId,
                    'lang' => Language::getDefaultLang(),
                ])->execute();
                if (is_array($field['_value'])) {
                    foreach ($field['_value'] as $key => $value) {
                        Yii::$app->db->createCommand()->insert('file', [
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->threadId,
                            'file' => $value,
                            'name' => $_POST['StructureCat'][$field['key'] . '-ownname'][$key],
                            'lang' => Language::getDefaultLang(),
                        ])->execute();
                    }
                }
            }

        }

    }


}
