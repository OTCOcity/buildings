<?php

namespace frontend\controllers;

use frontend\models\Building;
use yii\web\Controller;

class MainController extends Controller
{
    public $layout = 'main.twig';

    public function actionIndex($id = null)
    {
        $buildings = Building::find()
            ->where(['visible' => 1])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->render('index', [
            'buildings' => $buildings,
        ]);
    }
}
