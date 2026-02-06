<?php
namespace frontend\controllers;

use common\models\Thread;
use yii\web\Controller;

/**
 * About controller
 */
class AboutController extends Controller
{

    public function actionIndex($id)
    {
        $thread = Thread::findOne($id);
        $page = $thread->model;

        return $this->render('index.twig', [
            'page' => $page,
            'thread' => $thread
        ]);
    }

}
