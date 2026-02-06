<?php

namespace frontend\models;

use backend\eadmin\config\Language;
use common\models\Thread;
use frontend\components\MiscData;
use frontend\components\MiscFunc;
use Yii;

/**
 * This is the model class for table "b_object".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property integer $source_id
 * @property string $block_key
 * @property string $name
 * @property string $link
 * @property string $address
 * @property float $price
 * @property float $number
 * @property string $options
 * @property integer $lang
 * @property integer $obj_room_type_id
 * @property integer $obj_city_id
 * @property integer $obj_district_id
 * @property integer $obj_street_id
 * @property integer $obj_type_id
 * @property integer $obj_rent_type_id
 * @property integer $sort
 *
 * @property string $url
 * @property Thread $thread
 * @property array $images
 */
class BObject extends \yii\db\ActiveRecord
{


    public $_thread;

    static public $fieldNames = [
        'number' => ['label' => 'id'],

        'visible' => ['label' => 'активен', 'type' => 'boolean'],
        'deleted' => ['label' => 'удален', 'type' => 'boolean'],

        'name' => ['label' => 'наименование'],

        'address' => ['label' => 'адрес'],
        'city' => ['label' => 'город'],
        'district' => ['label' => 'район'],
        'street' => ['label' => 'улица'],

        'objectType' => ['label' => 'тип объекта'],
        'objectRentType' => ['label' => 'тип сделки'],
        'objectRoomType' => ['label' => 'количество комнат'],

        'about' => ['label' => 'описание'],

        'sq' => ['label' => 'общая площадь'],
        'floor' => ['label' => 'этаж'],
        'floors' => ['label' => 'сколько этажей в доме'],
        'baths' => ['label' => 'сколько ванных'],
        'badrooms' => ['label' => 'количество спален'],
        'price' => ['label' => 'цена', 'type' => 'price'],
    ];

    public $deleted;
    public $city;
    public $district;
    public $street;
    public $objectType;
    public $objectRentType;
    public $objectRoomType;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_object';
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

    public function getUrl() {
        return $this->thread->url . '/' . $this->link;
    }

    public function getImages() {

        return $this->hasMany(Image::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' =>  'gallery_images'])->orderBy('id');

    }

    public function getPriceFormat() {
        return MiscFunc::priceFormat($this->price);
    }

    public function getRentType() {
        return $this->hasOne(ObjRentType::className(), ['id' => 'obj_rent_type_id']);
    }

    public function getType() {
        return $this->hasOne(ObjType::className(), ['id' => 'obj_type_id']);
    }


    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            // Удаление
            if ($this->deleted) {
                $this->delete();
                return false;
            }

            // Get or add room type
            if ($this->city) {
                $roomType = ObjRoomType::findOne(['name' => $this->objectRoomType]);
                if ($roomType === null) {
                    $roomType = new ObjRoomType();
                    $roomType->name = $this->objectRoomType;
                    $roomType->save(false);
                }
                $this->obj_room_type_id = $roomType->id;
            }

            // Get or add city
            if ($this->city) {
                $city = ObjCity::findOne(['name' => $this->city]);
                if ($city === null) {
                    $city = new ObjCity();
                    $city->name = $this->city;
                    $city->save(false);
                }
                $this->obj_city_id = $city->id;
            }

            // Get or add district
            if ($this->city && $this->district) {
                $district = ObjDistrict::findOne(['name' => $this->district, 'city_id' => $this->obj_city_id]);
                if ($district === null) {
                    $district = new ObjDistrict();
                    $district->name = $this->district;
                    $district->city_id = $this->obj_city_id;
                    $district->save(false);
                }
                $this->obj_district_id = $district->id;
            }

            // Get or add street
            if ($this->street && $this->district && $this->city) {
                $street = ObjStreet::findOne(['name' => $this->street, 'city_id' => $this->obj_city_id, 'district_id' => $this->obj_district_id]);
                if ($street === null) {
                    $street = new ObjStreet();
                    $street->name = $this->street;
                    $street->city_id = $this->obj_city_id;
                    $street->district_id = $this->obj_district_id;
                    $street->save(false);
                }
                $this->obj_street_id = $street->id;
            }

            // Get or add object type
            if ($this->objectType) {
                $objectType = ObjType::findOne(['name' => $this->objectType]);
                if ($objectType === null) {
                    $objectType = new ObjType();
                    $objectType->name = $this->objectType;
                    $objectType->save(false);
                }
                $this->obj_type_id = $objectType->id;
            }

            // Get or add object rent type
            if ($this->objectRentType) {
                $objectRentType = ObjRentType::findOne(['name' => $this->objectRentType]);
                if ($objectRentType === null) {
                    $objectRentType = new ObjRentType();
                    $objectRentType->name = $this->objectRentType;
                    $objectRentType->save(false);
                }
                $this->obj_rent_type_id = $objectRentType->id;
            }

            return true;
        }
        return false;
    }


    public function getProps() {

        $props = MiscData::getDbData('b_object_prop', ['lang' => Language::getDefaultLang()], 'sort');
        $propArr = [];
        foreach ($props as $prop) {
            $prop['name'] = mb_strtolower($prop['name'], 'utf-8');
            $propArr[md5($prop['name'])] = true;
        }

        foreach (explode(PHP_EOL, $this->options) as $row) {
            $option = explode(':', $row);

            $option[0] = trim($option[0]);
            $option[1] = trim($option[1]);

            if (!$option[0] || !$option[1]) continue;


            if ($option[0] && $option[1] && $propArr[md5( mb_strtolower($option[0], 'utf-8'))]) {
                $result[] = (object)[
                  'name' => $option[0],
                  'value' => $option[1],
                ];
            }
        }


        return $result;
    }

}
