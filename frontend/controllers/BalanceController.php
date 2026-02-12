<?php
namespace frontend\controllers;

use common\models\Thread;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * About controller
 */
class BalanceController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    throw new ForbiddenHttpException();
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index.twig', [
        ]);
    }

}
