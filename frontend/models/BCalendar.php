<?php

namespace frontend\models;

use Yii;

/**
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $link
 * @property integer $date_from
 * @property integer $date_to
 * @property integer $date_from_2
 * @property integer $date_to_2
 * @property integer $visible
 * @property integer $sort
 *
 * @property integer $dateFrom
 * @property integer $dateTo
 * @property integer $dateFrom2
 * @property integer $dateTo2
 */
class BCalendar extends \yii\db\ActiveRecord
{

    protected $_months = false;
    public $monthsArr = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_standart_calendar';
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
     * @deprecated use getMonthList
     * @return array|bool
     */
    public function getMonths() {

        if ($this->_months === false) {

            $monthFrom = (int)date('n', $this->date_from);
            $monthTo = (int)date('n', $this->date_to);

            $this->_months = [
                $monthFrom,
                $monthTo
            ];

        }

        return $this->_months;

    }

    public function isMonthActive($month) {

        return ($month->date >= $this->dateFrom && $month->date <= $this->dateTo) ||
            ($month->date >= $this->dateFrom2 && $month->date <= $this->dateTo2);
    }
    public function isMonthStart($month) {

        return ($this->date_from && date('nY', $month->date) == date('nY', $this->dateFrom)) ||
            ($this->date_from_2 && date('nY', $month->date) == date('nY', $this->dateFrom2));
    }

    public function isMonthEnd($month) {

        return ($this->date_to && date('nY', $month->date) == date('nY', $this->dateTo)) ||
            ($this->date_to_2 && date('nY', $month->date) == date('nY', $this->dateTo2));
    }

    public function getDateFrom() {
        $date = new \DateTime();
        $date->setTimestamp($this->date_from);
        $date->modify('first day of this month');

        return $date->getTimestamp();
    }

    public function getDateTo() {
        $date = new \DateTime();
        $date->setTimestamp($this->date_to);
        $date->modify('last day of this month');

        return $date->getTimestamp();
    }

    public function getDateFrom2() {
        $date = new \DateTime();
        $date->setTimestamp($this->date_from_2);
        $date->modify('first day of this month');

        return $date->getTimestamp();
    }

    public function getDateTo2() {
        $date = new \DateTime();
        $date->setTimestamp($this->date_to_2);
        $date->modify('last day of this month');

        return $date->getTimestamp();
    }

    public function getMonthList($calendarList) {

        $dateFrom = false;
        $dateTo = false;
        foreach ($calendarList as $c) {
            if ( ($c->date_from == 0 || $c->date_to == 0) && ($c->date_from_2 == 0 || $c->date_to_2 == 0) ) continue;
            if ( ($dateFrom === false || $c->date_from < $dateFrom) && $c->date_from > 0) {
                $dateFrom = $c->date_from;
            }
            if ( ($dateTo === false || $c->date_to > $dateTo) && $c->date_to > 0) {
                $dateTo = $c->date_to;
            }
            if ( ($dateFrom === false || $c->date_from_2 < $dateFrom) && $c->date_from_2 > 0) {
                $dateFrom = $c->date_from_2;
            }
            if ( ($dateTo === false || $c->date_to_2 > $dateTo) && $c->date_to_2 > 0) {
                $dateTo = $c->date_to_2;
            }
        }

        $date = new \DateTime();
        $date->setTimestamp($dateFrom);
        $result = [];
        while ($date->getTimestamp() <= $dateTo) {

            $result[] = (object)[
                'n' => $date->format('n'),
                'date' => $date->getTimestamp(),
                'name' => $this->monthsArr[($date->format('n') - 1) % 12],
            ];
            $date->modify( 'first day of next month' );
        }



        return $result;
    }

}
