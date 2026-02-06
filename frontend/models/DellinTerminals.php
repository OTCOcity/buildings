<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dellin_terminals".
 *
 * @property integer $id
 * @property integer $city_id
 * @property string $city_name
 * @property string $city_code
 * @property integer $code_id
 * @property string $city_lat
 * @property string $city_lng
 * @property string $city_url
 * @property string $timeshift
 * @property string $requestEndTime
 * @property string $sfrequestEndTime
 * @property integer $day2dayRequest
 * @property integer $preorderRequest
 * @property integer $freeStorageDays
 * @property integer $t_id
 * @property string $t_name
 * @property string $t_address
 * @property string $t_fulladdress
 * @property string $t_lat
 * @property string $t_lng
 * @property integer $t_isOffice
 * @property integer $t_onlyReceive
 * @property integer $t_onlyGiveout
 * @property string $worktables
 */
class DellinTerminals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dellin_terminals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'code_id', 'day2dayRequest', 'preorderRequest', 'freeStorageDays', 't_id', 't_isOffice', 't_onlyReceive', 't_onlyGiveout'], 'integer'],
            [['city_lat', 'city_lng', 'timeshift', 't_lat', 't_lng'], 'number'],
            [['worktables'], 'required'],
            [['worktables'], 'string'],
            [['city_name', 'city_code'], 'string', 'max' => 50],
            [['city_url'], 'string', 'max' => 255],
            [['requestEndTime', 'sfrequestEndTime'], 'string', 'max' => 10],
            [['t_name', 't_address'], 'string', 'max' => 100],
            [['t_fulladdress'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'city_name' => 'City Name',
            'city_code' => 'City Code',
            'code_id' => 'Code ID',
            'city_lat' => 'City Lat',
            'city_lng' => 'City Lng',
            'city_url' => 'City Url',
            'timeshift' => 'Timeshift',
            'requestEndTime' => 'Request End Time',
            'sfrequestEndTime' => 'Sfrequest End Time',
            'day2dayRequest' => 'Day2day Request',
            'preorderRequest' => 'Preorder Request',
            'freeStorageDays' => 'Free Storage Days',
            't_id' => 'T ID',
            't_name' => 'T Name',
            't_address' => 'T Address',
            't_fulladdress' => 'T Fulladdress',
            't_lat' => 'T Lat',
            't_lng' => 'T Lng',
            't_isOffice' => 'T Is Office',
            't_onlyReceive' => 'T Only Receive',
            't_onlyGiveout' => 'T Only Giveout',
            'worktables' => 'Worktables',
        ];
    }
}
