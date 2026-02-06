<?php

namespace frontend\controllers\backup;

use frontend\models\BSiteUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class Site_userController extends Controller
{


    public function actionIndex($id, $params)
    {

        // Logout
        if (isset($_GET['logout'])) {
            \Yii::$app->user->logout();
            return $this->redirect("/");
        }

        // Go home if logged
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect("/");
        }


        $user = new BSiteUser();
        if (\Yii::$app->request->isPost) {

            $logUser = BSiteUser::find()->where(['visible' => 1, 'name' => \Yii::$app->request->post('login'), 'password' => \Yii::$app->request->post('password')])->one();
            if ($logUser) {

                \Yii::$app->user->login($logUser, 86400);
                return $this->goBack();

            }

            $user->name =  \Yii::$app->request->post('login');

        }




        return $this->render('index.twig', [
            'user' => $user
        ]);
    }


    public function actionView($id, $params)
    {

        throw new NotFoundHttpException();
    }
}
