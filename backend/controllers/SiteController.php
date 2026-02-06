<?php
namespace backend\controllers;

use common\models\LoginForm;
use FontLib\Table\Type\head;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionError()
    {

        if (Yii::$app->user->isGuest) {

            return $this->actionLogin();
        } else {

            return $this->render('error', ['name' => "Страница не существует", 'message' => 'Страница была перенесена или удалена']);
        }

    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionLogin()
    {

        $this->layout = "@backend/views/layouts/login.twig";

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            header('Location: /admin/threads/1');
            die();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
