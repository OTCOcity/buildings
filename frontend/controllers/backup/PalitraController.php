<?php
namespace frontend\controllers\backup;

use Yii;
use common\models\Thread;
use frontend\components\Misc;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Site controller
 */
class PalitraController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $palitra = $thread->model;

        Misc::$bodyClassname = "products palitra";



        return $this->render('index.twig', ['palitra' => $palitra]);
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
