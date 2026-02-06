<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "b_office".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $adres
 * @property string $info_header
 * @property string $info_text
 * @property string $location
 */
class BOffice extends \yii\db\ActiveRecord
{

    public $_coords = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_office';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'block_id'], 'integer'],
            [['info_text'], 'string'],
            [['block_key'], 'string', 'max' => 50],
            [['name', 'adres', 'info_header', 'location'], 'string', 'max' => 255],
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
            'adres' => 'Adres',
            'info_header' => 'Info Header',
            'info_text' => 'Info Text',
            'location' => 'Location',
        ];
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
