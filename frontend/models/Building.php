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
 * @property string $floor
 * @property string $area
 * @property string $rent_cost
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

    public $rentCostValue = 0;
    public $paymentAmountValue = 0;
    public $netValue = 0;
    public $netBadge = '';
    public $netClass = '';
    public $badgeClass = '';

    public static function tableName()
    {
        return 'b_buildings';
    }

    public function rules()
    {
        return [
            [['source_id', 'thread_id', 'block_id', 'sort', 'visible', 'purchase_date', 'payment_date', 'next_insurance_date'], 'integer'],
            [['files', 'description', 'history'], 'string'],
            [['block_key', 'name', 'link', 'mortgage_size', 'payment_amount', 'position', 'floor', 'area', 'rent_cost'], 'string', 'max' => 255],
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
            'floor' => 'Floor',
            'area' => 'Area',
            'rent_cost' => 'Rent Cost',
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

        /** Files rel */
    public function getFileList() {
        return $this->hasMany(File::className(), ['item_id' => 'id'])->where(['table' => $this->tableName(), 'key' => 'files'])->orderBy('sort, id desc');
    }

    public function getFileGroups() {
        $filesByGroup = [];

        foreach ($this->fileList as $file) {
            $name = is_array($file) ? ($file['name'] ?? '') : ($file->name ?? '');
            $url  = is_array($file) ? ($file['file'] ?? '')  : ($file->file ?? '');

            $name = trim((string)$name);

            $groupKey = '';
            $displayName = $name;

            $pos = mb_strpos($name, '_');

            if ($pos !== false && $pos > 0) {
                $possibleGroup = trim(mb_substr($name, 0, $pos));
                $possibleName  = trim(mb_substr($name, $pos + 1));

                if ($possibleGroup !== '' && $possibleName !== '') {
                    $groupKey = $possibleGroup;
                    $displayName = $possibleName;
                }
            }

            $filesByGroup[$groupKey][] = [
                'name' => $displayName,
                'url'  => '/upload/orig/' . $url,
            ];
        }

        // сортировка групп: пустую группу вниз
        uksort($filesByGroup, function ($a, $b) {
            if ($a === '') return 1;
            if ($b === '') return -1;
            return strnatcasecmp($a, $b);
        });

        // сортировка файлов внутри каждой группы
        foreach ($filesByGroup as &$items) {
            usort($items, function ($a, $b) {
                return strnatcasecmp($a['name'], $b['name']);
            });
        }
        unset($items);

        return $filesByGroup;
    }
}
