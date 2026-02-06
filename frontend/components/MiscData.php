<?php

namespace frontend\components;

use yii\db\Query;

class MiscData
{

    static private $_data;
    static private $_dataModel;

    static public function getDbData($table, $query = [], $order = false, $limit = false) {

        $querySer = json_encode($query) . $order . $limit;
        if (!isset(self::$_data[$table]) || !isset(self::$_data[$table][$querySer])) {
            $q = (new Query())->select('*')->from($table);
            if ($query) {
                $q->where($query);
            }
            if ($order) {
                $q->orderBy($order);
            }
            if ($limit) {
                $q->limit($limit);
            }

            self::$_data[$table][$querySer] = $q->all();
        }

        return self::$_data[$table][$querySer];
    }

    static public function getDbDataModel($model, $query = [], $order = false, $limit = false) {

        $querySer = json_encode($query) . $order . $limit;
        if (!isset(self::$_dataModel[$model]) || !isset(self::$_dataModel[$model][$querySer])) {
            $q = call_user_func($model .'::find');
            if ($query) {
                $q->where($query);
            }
            if ($order) {
                $q->orderBy($order);
            }
            if ($limit) {
                $q->limit($limit);
            }

            self::$_dataModel[$model][$querySer] = $q->all();
        }

        return self::$_dataModel[$model][$querySer];
    }


}