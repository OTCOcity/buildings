<?php
namespace frontend\controllers\backup;

use common\models\Thread;
use frontend\components\Misc;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Site controller
 */
class FeaturesController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        $slides = [];
        foreach ($page->features as $key => $val) {

            $slides[floor($key / 2)][] = $val;



        }


        Misc::$bodyClassname = "about";

        return $this->render('index.twig', ['page' => $page, 'thread' => $thread, 'slides' => $slides]);
    }


    /**
     * @param $id
     * @param $params
     * @throws HttpException
     */
    public function actionView($id, $params)
    {



        throw new HttpException(404 ,'Страница не существует');



    }


}
