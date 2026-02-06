<?php
namespace backend\controllers;

use backend\eadmin\config\Config;
use common\models\Module;
use common\models\Thread;
use common\models\UserAccess;
use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class UsersController extends Controller
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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {

        if (Yii::$app->arules->isEditor) throw new ForbiddenHttpException("Доступ запрещен");

        $usersQuery =  User::find();
        if (Yii::$app->user->identity->status == 0) { // Суперадмин

        } else { // Остальные пользователи
            $usersQuery->andWhere('status > 0');
        }
        $users = $usersQuery->all();


        return $this->render('index.twig', ['users' => $users, 'statuses' => User::$statusArr]);
    }

    public function actionCreate() {

        if (Yii::$app->user->identity->status == 2) {
            $this->redirect("/admin/users");
            Yii::$app->end();
        }

        $user = new User();

        if (Yii::$app->request->isPost && $user->load(Yii::$app->request->post())) {
            if ($user->save()) {
                if ($user->password) {

                    if (!$user->password) $user->password = "password";

                    $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
                    $user->save(false);
                }
                $this->redirect("/admin/users/" . $user->id);
            }
        }

        $statuses =  User::$statusArr;
        if (Yii::$app->user->identity->status != 0) { // Убираем статус суперадмина
            unset($statuses[0]);
        }

        return $this->render('edit.twig', ['user' => $user, 'statuses' => $statuses]);
    }


    public function actionEdit($id)
    {


        if (Yii::$app->user->identity->status == 2) {
            $this->redirect("/admin/users");
            Yii::$app->end();
        }

        $user = User::findOne($id);
        if ($user === null) throw new NotFoundHttpException("Пользователя не существует");

        if (Yii::$app->request->isPost && $user->load(Yii::$app->request->post())) {
            if ($user->save()) {

                if ($user->password) {
                    $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
                    $user->save(false);
                }
                $this->refresh();
            }
        }

        // Нельзя редактировать суперадмина остальным
        if (Yii::$app->user->identity->status != 0 && $user->status == 0) {
            $this->redirect("/admin/users");
        }

        $statuses =  User::$statusArr;
        if (Yii::$app->user->identity->status != 0) { // Убираем статус суперадмина
            unset($statuses[0]);
        }


        // Пава пользователя
        $ruleThreads = Thread::find()->innerJoin('module', 'module.id = thread.module')->where(['module.active' => 1, 'module.visible' => 1])->orderBy('lvl, sort')->all();
        if (Yii::$app->request->isPost) { // Сохранение
            $post = Yii::$app->request->post();

            if ($post['block'] || $post['thread']) {


                UserAccess::deleteAll(['user_id' => $id]);
                $ua = new UserAccess();

                if (is_array($post['block'])) {
                    foreach ($post['block'] as $key => $val) {
                        foreach ($val as $bkey => $b) {
                            foreach ($b as $iley => $i) {

//                            var_dump($id . "." . $key . "." . $bkey . "." . $iley . "." . $i);
                                $ua->isNewRecord = true;
                                $ua->id = null;
                                $ua->user_id = $id;
                                $ua->thread_id = $bkey;
                                $ua->block_key = $iley;
                                $ua->action = $key;
                                $ua->save(false);
                            }
                        }

                    }
                }

                if (is_array($post['thread'])) {
                    foreach ($post['thread'] as $key => $val) {
                        foreach ($val as $bkey => $b) {

//                            var_dump($id . "." . $key . "." . $bkey . "." . $b);

                            $ua->isNewRecord = true;
                            $ua->id = null;
                            $ua->user_id = $id;
                            $ua->thread_id = $bkey;
                            $ua->block_key = "";
                            $ua->action = $key;
                            $ua->save(false);
                        }
                    }
                }



            }


            $this->refresh();

        }


        return $this->render('edit.twig', ['user' => $user, 'statuses' => $statuses, 'ruleThreads' => $ruleThreads]);
    }

    public function actionActivetoggle($id)
    {
        if (Yii::$app->user->identity->status == 2) {
            $this->redirect("/admin/users");
            Yii::$app->end();
        }

        $user = User::findOne($id);
        $user->active = !$user->active;
        $user->save(false);
        $this->redirect("/admin/users");

    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->status == 2) {
            $this->redirect("/admin/users");
            Yii::$app->end();
        }

        User::deleteAll(['id' => $id]);
        $this->redirect("/admin/users");

    }

}
