<?php

namespace frontend\controllers;

use frontend\models\Building;
use Yii;
use yii\web\Controller;

class MainController extends Controller
{
    public $layout = 'main.twig';

    public function actionIndex($id = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('forbidden.twig');
        }

        $buildings = Building::find()
            ->where(['visible' => 1])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        return $this->render('index.twig', [
            'buildings' => $buildings,
        ]);
    }
}
