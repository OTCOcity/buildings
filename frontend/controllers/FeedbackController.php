<?php

namespace frontend\controllers;

use frontend\models\forms\FeedbackForm;
use yii\web\Controller;
use yii\web\Response;

class FeedbackController extends Controller
{

    public function actionIndex()
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;

        $feedBackForm = new FeedbackForm();
        if (\Yii::$app->request->isPost && $feedBackForm->load(\Yii::$app->request->post())) {

            if ($feedBackForm->validate()) {

                $feedBackForm->send();
                $feedBackForm->save();
                return [
                  'function' => 'feedbackSuccess',
                  'data' => [
                      'data' => $feedBackForm->attributes,
                      'scenario' => $_REQUEST['scenario']
                  ]
                ];


            } else {

                return $feedBackForm->errors;
            }

        }
    }


}
