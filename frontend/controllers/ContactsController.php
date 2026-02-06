<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Contacts controller
 */
class ContactsController extends Controller
{

    public function actionIndex()
    {

        return $this->render('index.twig');
    }


    public function actionView($id, $params)
    {
        throw new NotFoundHttpException();

    }


}
