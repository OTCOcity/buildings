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
class PriceController extends Controller
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


        $search = trim(strip_tags($_GET['search']));

        if (mb_strlen($search)) {
            $page->search = $_GET['search'];
        }

        $priceStructure = $page->priceStructure;

        Misc::$bodyClassname = "price bgNum2";




        return $this->render('index.twig', ['page' => $page, 'priceStructure' => $priceStructure]);
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
