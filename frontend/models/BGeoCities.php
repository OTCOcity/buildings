<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "b_geo_cities".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $location
 * @property integer $visible
 */
class BGeoCities extends \yii\db\ActiveRecord
{

    public $_coords = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_geo_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id', 'visible'], 'integer'],
            [['block_key'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255],
            [['location'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'location' => 'Location',
            'visible' => 'Visible',
        ];
    }


    public function getItems() {

        return $this->hasMany(BGeoItem::className(), ['block_id' => 'id'])->where(['block_key' => 'geo_cities', 'visible' => 1])->orderBy('sort');
    }


    public function getCoords() {

        if (count($this->_coords) == 0) {

            $locArr = explode(";", $this->location);
            $this->_coords['lng'] = $locArr[1];
            $this->_coords['lat'] = $locArr[0];
            $this->_coords['zoom'] = $locArr[2];


        }
        return $this->_coords;
    }

}
