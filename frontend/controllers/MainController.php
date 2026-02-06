<?php

namespace frontend\controllers;

use common\models\Thread;
use frontend\components\MiscFunc;
use frontend\models\BNews;
use frontend\models\BWork;
use frontend\models\CMain;
use frontend\models\forms\FeedbackForm;
use Yii;
use yii\web\Controller;

class MainController extends Controller
{

    public $layout = 'main.twig';

    public function actionIndex($id)
    {


        // Main page information
        $thread = Thread::findOne($id);

        /** @var CMain $page */
        $page = $thread->model;

        // Breadcrumbs

        // Options
        $options = MiscFunc::getThreadData('options');

        return $this->render('index.twig', [
            'thread' => $thread,
            'page' => $page,
            'options' => $options,
        ]);
    }


}
