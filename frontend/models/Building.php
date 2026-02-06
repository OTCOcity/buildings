<?php

namespace frontend\models;

/**
 * This is the model class for table "b_buildings".
 *
 * @property int $id
 * @property int $source_id
 * @property int $thread_id
 * @property int $block_id
 * @property string $block_key
 * @property int $sort
 * @property int $visible
 * @property string $lang
 * @property string $name
 * @property string $link
 * @property string $mortgage_size
 * @property string $payment_amount
 * @property int $purchase_date
 * @property int $payment_date
 * @property int $next_insurance_date
 * @property string $position
 * @property string|null $files
 * @property string|null $description
 * @property string|null $history
 */
class Building extends \yii\db\ActiveRecord
{
    public $_coords = [];

    public static function tableName()
    {
        return 'b_buildings';
    }

    public function rules()
    {
        return [
            [['source_id', 'thread_id', 'block_id', 'sort', 'visible', 'purchase_date', 'payment_date', 'next_insurance_date'], 'integer'],
            [['files', 'description', 'history'], 'string'],
            [['block_key', 'name', 'link', 'mortgage_size', 'payment_amount', 'position'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_id' => 'Source ID',
            'thread_id' => 'Thread ID',
            'block_id' => 'Block ID',
            'block_key' => 'Block Key',
            'sort' => 'Sort',
            'visible' => 'Visible',
            'lang' => 'Lang',
            'name' => 'Name',
            'link' => 'Link',
            'mortgage_size' => 'Mortgage Size',
            'payment_amount' => 'Payment Amount',
            'purchase_date' => 'Purchase Date',
            'payment_date' => 'Payment Date',
            'next_insurance_date' => 'Next Insurance Date',
            'position' => 'Position',
            'files' => 'Files',
            'description' => 'Description',
            'history' => 'History',
        ];
    }

    public function getCoords()
    {
        if (count($this->_coords) === 0 && !empty($this->position)) {
            $positionParts = explode(';', $this->position);
            $this->_coords['lat'] = $positionParts[0] ?? null;
            $this->_coords['lng'] = $positionParts[1] ?? null;
            $this->_coords['zoom'] = $positionParts[2] ?? null;
        }

        return $this->_coords;
    }
}
