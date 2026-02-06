<?php

namespace backend\models;

use backend\eadmin\config\Config;
use backend\eadmin\config\Language;
use backend\eadmin\datatype\Datatype;
use common\models\Thread;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;


class StructureBlock extends StructureItem
{

    static public $prefix = "b_";
    static public $table = "";
    public $config = [];
    private $_fields = [];
    private $_tab;
    public $threadId = 0;
    public $blockId = 0;
    public $blockKey = "";
    public $structureType = "block";
    public $blockLang = false;
    public $defaultId;


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
     * Есть ли колонка сортировки
     * @return bool
     */
    public function getSortable()
    {

        $table = Yii::$app->db->schema->getTableSchema($this->tableName());

        return isset($table->columns['sort']);
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


    /**
     * Есть ли колонка видимости
     * @return bool
     */
    public function getVisibable()
    {

        $table = Yii::$app->db->schema->getTableSchema($this->tableName());

        return isset($table->columns['visible']);
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
            foreach ($this->tabs as $tab) {
                if (isset($tab['fields']) && is_array($tab['fields'])) {

                    foreach ($tab['fields'] as $tabKey => $field) {

                        $this->_fields[$field['key']] = $field;
                        $this->_fields[$field['key']]['_tab'] = $tabKey;
                    }

                }

            }


        }
        return $this->_fields;
    }


    public function getInnerCounts()
    {
        foreach ($this->tabs as $key => $tab) {
            if (isset($tab['inner_blocks']) && $tab['inner_blocks']) {

                $this->config['tabs'][$key]['_count'] = (new \yii\db\Query())->from('b_' . $tab['inner_blocks'])->where(
                    [
//                        'thread_id' => $this->threadId,
                        'block_id' => $this->id,
                        'block_key' => $this->config['key']]
                )->count();

            }
        }


    }


    public function renderField($key, $form = null)
    {


        $dt = new Datatype($this, $this->fields[$key], $form);


        return $dt->renderField();

    }


    /**
     * Загрузка всех полей из базы данных по id
     */
    public function loadById($id)
    {

        // Загрузка для дефолтного языка
        $dataDefault = (new \yii\db\Query())
            ->select(['*'])
            ->from($this->tableName())
            ->where(
                ['id' => $id]
            )
            ->limit(1)
            ->one();

        $this->defaultId = $dataDefault['id'];


        // Редирект на главную запись и данный язык
        if ($dataDefault['lang'] !== Language::getDefaultLang()) {
            $mainBlock = (new \yii\db\Query())
                ->select(['*'])
                ->from($this->tableName())
                ->where(
                    [
                        'thread_id' => $dataDefault['thread_id'],
                        'block_id' => $dataDefault['block_id'],
                        'block_key' => $dataDefault['block_key'],
                        'lang' => Language::getLang(),
                    ]
                )
                ->limit(1)
                ->one();

            return ['redirect', "/admin/blocks/{$this->config['key']}/{$mainBlock['id']}?lang={$dataDefault['lang']}"];
        }

        // Загрузка для текущего языка
        if (Language::getLang() !== Language::getDefaultLang()) {
            $data = (new \yii\db\Query())
                ->select(['*'])
                ->from($this->tableName())
                ->where(
                    [
                        'thread_id' => $dataDefault['thread_id'],
                        'block_id' => $dataDefault['block_id'],
                        'block_key' => $dataDefault['block_key'],
                        'source_id' => $id,
                        'lang' => Language::getLang(),
                    ]
                )
                ->limit(1)
                ->one();

            // При отсутствии создаем новую запись
            if (!$data) {

                $block = new StructureBlock(Config::getConfig($this->config['key'], true, $dataDefault['block_key']));
                $block->threadId = $dataDefault['thread_id'];
                $block->blockId = $dataDefault['block_id'];
                $block->blockKey = $dataDefault['block_key'];
                $block->blockLang = Language::getLang();
                $block->create($id);

                $data = $block->attributes;
                $data['id'] = $dataDefault['id'];

            }
        } else {
            $data = $dataDefault;
        }


        $this->loadData($data, $dataDefault);

        $this->getInnerCounts();


    }


    public function loadData($data, $dataDefault = false)
    {

        if ($dataDefault === false) {
            $dataDefault = (new Query())
                ->select('*')
                ->from('b_' . $this->config['key'])
                ->where([
                    'thread_id' => $data['thread_id'],
                    'block_id' => $data['block_id'],
                    'block_key' => $data['block_key'],
                    'source_id' => $data['id'],
                    'lang' => Language::getDefaultLang(),
                ])
                ->one();
        }

        if ($data['id']) { // Загрузка из таблицы

            $this->threadId = $data['thread_id'];
            $this->blockId = $data['block_id'];
            $this->blockKey = $data['block_key'];

            // Из своей таблицы
            $this->setAttributes($dataDefault, false);

            $this->id = $data['id'];
            $this->defaultId = $dataDefault['id'];

            // Загрузка в _value
            foreach ($this->_fields as $key => $field) {

                if ($field['lang']) {
                    $this->setAttribute($key, $data[$key], false);
                    $this->_fields[$key]['_value'] = $data[$field['key']];
                    $this->_fields[$key]['_value_list'] = Datatype::renderListField($field['type'], $data[$field['key']], $field);
                } else {
                    $this->_fields[$key]['_value'] = $dataDefault[$field['key']];
                    $this->_fields[$key]['_value_list'] = Datatype::renderListField($field['type'], $dataDefault[$field['key']], $field);
                }

            }

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
                            'item_id' => $field['lang'] ? $this->id : $this->defaultId,
//                            'lang' => $field['lang'] ? Language::getLang() : Language::getDefaultLang()
                        ])
                        ->all();


                    $da = ArrayHelper::map($data, 'id', 'value');
                    $this->_fields[$key]['_value'] = $da;
                    if (is_array($field['data']['values'])) {
                        $this->_fields[$key]['_value_list'] = "";

                        $resArr = [];
                        foreach ($da as $val) {
                            $resArr[] = $field['data']['values'][$val];
                        }
                        $this->_fields[$key]['_value_list'] = implode(", ", $resArr);
                        // Edit in list disable
                        /*
                                              foreach ($da as $val) {
                                                  $this->_fields[$key]['_value_list'] .= "
                                                      <div class='block-list__multiselect-item'
                                                      data-table='" . $this->tableName() . "'
                                                      data-key='{$field['key']}'
                                                      data-item-id='{$this->id}'
                                                      data-value='{$val}'>
                                                          {$field['data']['values'][$val]}
                                                      </div>
                                                  ";
                                              }
                                              */
                    } else {
                        $this->_fields[$key]['_value_list'] = implode(", ", $da);
                    }
                }

                // Изображения
                if ($field['type'] == 'image') {

                    $data = (new \yii\db\Query())
                        ->select(['file', 'name', 'id'])
                        ->from('image')
                        ->where([
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $field['lang'] ? $this->id : $this->defaultId,
//                            'lang' => $field['lang'] ? Language::getLang() : Language::getDefaultLang()
                        ])
                        ->orderBy('id')
                        ->all();


                    $this->_fields[$key]['_value'] = $data;
                    $this->_fields[$key]['_value_list'] = $data[0]['file'] ? "<img src='" . (Yii::$app->params['siteurl']) . "/upload/thumb/" . ($data[0]['file']) . "' style='height: 20px; width: 20px; border-radius: 50%;'>" : "";

                }

                // Файл
                if ($field['type'] == 'file') {

                    $data = (new \yii\db\Query())
                        ->select(['file', 'name', 'id'])
                        ->from('file')
                        ->where([
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $field['lang'] ? $this->id : $this->defaultId,
//                            'lang' => $field['lang'] ? Language::getLang() : Language::getDefaultLang()
                        ])
                        ->all();

                    $this->_fields[$key]['_value'] = $data;
                    $this->_fields[$key]['_value_list'] = $data[0]['name'] ? $data[0]['name'] : "";

                }
            }


        } elseif (is_array($data['StructureBlock'])) { // Загрузка из пост


            // Загрузка в аттрибуты
            $this->setAttributes($data['StructureBlock'], false);

            // Загрузка в _value
            foreach ($this->_fields as $key => $field) {
                $this->_fields[$key]['_value'] = $data['StructureBlock'][$field['key']];
            }

        }


    }


    public function saveSeo($post)
    {

        if (isset($post['StructureBlock']['seo_title']) && isset($post['StructureBlock']['seo_keywords']) && isset($post['StructureBlock']['seo_description'])) {
            Yii::$app->db->createCommand()->update($this->tableName(), [
                'seo_title' => $post['StructureBlock']['seo_title'],
                'seo_keywords' => $post['StructureBlock']['seo_keywords'],
                'seo_description' => $post['StructureBlock']['seo_description'],
            ], ['id' => $this->id,])->execute();
        }
    }


    public function saveData()
    {


        foreach ($this->fields as $field) {


            // Сохранение в свою таблицу
            $class = "backend\\eadmin\\datatype\\datatypes\\DT{$field['type']}";

            $saveValue = $class::beforeSave($field['_value'], $field);
            if ($saveValue !== null) {

                Yii::$app->db->createCommand()->update($this->tableName(), [

                    $field['key'] => $saveValue,

                ], [
                    'id' => $this->id,
                ])->execute();
            }


            // Селекты множественные
            if ($field['type'] == 'select' && $field['multiple']) {

                Yii::$app->db->createCommand()->delete('relations', [
                    'table' => $this->tableName(),
                    'key' => $field['key'],
                    'item_id' => $this->id,
                ])->execute();
                if (is_array($field['_value'])) {
                    foreach ($field['_value'] as $value) {
                        Yii::$app->db->createCommand()->insert('relations', [
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->id,
                            'value' => $value,
                        ])->execute();
                    }
                }
            }

            // Изображения
            if ($field['type'] == 'image') {

                Yii::$app->db->createCommand()->delete('image', [
                    'table' => $this->tableName(),
                    'key' => $field['key'],
                    'item_id' => $this->id,
                    'lang' => Language::getLang(),
                ])->execute();
                if (is_array($field['_value'])) {
                    foreach ($field['_value'] as $key => $value) {
                        Yii::$app->db->createCommand()->insert('image', [
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->id,
                            'file' => $value,
                            'name' => $_POST['StructureBlock'][$field['key'] . '-ownname'][$key],
                            'lang' => Language::getLang(),
                        ])->execute();
                    }
                }
            }

            // Файлы
            if ($field['type'] == 'file') {


                Yii::$app->db->createCommand()->delete('file', [
                    'table' => $this->tableName(),
                    'key' => $field['key'],
                    'item_id' => $this->id,
                    'lang' => Language::getLang(),
                ])->execute();
                if (is_array($field['_value'])) {
                    foreach ($field['_value'] as $key => $value) {
                        Yii::$app->db->createCommand()->insert('file', [
                            'table' => $this->tableName(),
                            'key' => $field['key'],
                            'item_id' => $this->id,
                            'file' => $value,
                            'name' => $_POST['StructureBlock'][$field['key'] . '-ownname'][$key],
                            'lang' => Language::getLang(),
                        ])->execute();
                    }
                }
            }

        }

        if ($this->config['saveCallback']) {
            call_user_func($this->config['saveCallback'], $this, 'save');
        }
    }


    public function renderList($parentKey = "")
    {


        $query = (new \yii\db\Query())
            ->select(['*'])
            ->from($this->tableName())
            ->where([
                'thread_id' => $this->threadId,
                'block_id' => $this->blockId,
                'block_key' => $this->blockKey,
                'lang' => Language::getDefaultLang(),
            ]);


        if ($this->config['sort']) {

            $query->orderBy($this->config['sort']);

        } else if ($this->sortable) {

            $query->orderBy('sort, id');

        }

        $data = $query->all();


        return Yii::$app->view->render("/blocks/block_list.twig", ['data' => $data, 'block' => $this, 'parentKey' => $parentKey]);
    }

    public function renderInnerblocks($key, $parentKey)
    {


        $block = new StructureBlock(Config::getConfig($key, true));
//        $block->threadId = $this->threadId;
        $block->blockId = $this->id;
        $block->blockKey = $this->config['key'];

        return $block->renderList($parentKey);

    }


    /**
     * Возвращает tab в котром находятся блоки в родительском элементе
     */
    public function getTab()
    {

        if (is_numeric($this->_tab)) return $this->_tab;

        if ($this->blockKey) {
            $config = Config::getConfig($this->blockKey, true);
        } else {
            $thread = Thread::findOne($this->threadId);
            $config = Config::getConfig($thread->moduleinfo->controller);
        }
        if (is_array($config['tabs'])) {
            foreach ($config['tabs'] as $key => $tab) {
                if ($tab['inner_blocks'] == $this->config['key']) {
                    $this->_tab = $key;
                    return $key;
                }
            }
        }

        $this->_tab = null;
        return null;
    }


    public function create($sourceId= false)
    {

        $dataArr = [
            'thread_id' => $this->threadId,
            'block_id' => $this->blockId,
            'block_key' => $this->blockKey,
            'lang' => $this->blockLang ? $this->blockLang : Language::getDefaultLang(),
        ];

        if ($this->sortable) {

            // Если сортируется то добавляем поле сортировки
            $dataArr['sort'] = (new Query())->from($this->tableName())->count();


            // Если в сортировках есть дубликаты то нужно все отсортировать нормально
            if ($query = (new \yii\db\Query())->select(['COUNT(*) c'])->from($this->tableName())->groupBy('sort')->having('c > 1')->count()) {
                $this->sortInit();
            }

        }

        Yii::$app->db->createCommand()->insert($this->tableName(), $dataArr)->execute();
        $lastInsertId = Yii::$app->db->lastInsertID;
        Yii::$app->db->createCommand()->update($this->tableName(), ['source_id' => $sourceId ? $sourceId : $lastInsertId], ['id' => Yii::$app->db->lastInsertID])->execute();


        return $lastInsertId;

    }

    public function delete()
    {

        if (!$this->id) return false;

        Yii::$app->db->createCommand()->delete($this->tableName(), [
            'id' => $this->id,
        ])->execute();

        if ($this->config['deleteCallback']) {
            call_user_func($this->config['deleteCallback'], $this, 'delete');
        }


        return true;

    }


    /**
     * Дефолтная сортировка
     * @return int
     * @throws \yii\db\Exception
     */
    public function sortInit()
    {
        $row = (new Query())->select('id')->from($this->tableName())->orderBy('sort, id')->all();
        $sort = 0;
        foreach ($row as $val) {

            Yii::$app->db->createCommand()->update($this->tableName(), ['sort' => $sort], ['id' => $val['id']])->execute();
            $sort++;
        }

        return $sort - 1;
    }


    public function visibleToggle()
    {

        (new Query())->createCommand()->update(
            "b_{$this->config['key']}",
            ['visible' => (int)!$this->visible],
            ['source_id' => $this->source_id, 'thread_id' => $this->thread_id, 'block_id' => $this->block_id, 'block_key' => $this->block_key]
        )->execute();

        if ($this->config['saveCallback']) {
            call_user_func($this->config['saveCallback'], $this, 'visible');
        }

    }

}
