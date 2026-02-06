<?php
namespace backend\controllers;

use backend\models\Relations;
use backend\models\StructureCat;
use common\models\Module;
use common\models\Thread;
use frontend\models\Image;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Threads controller
 */
class ThreadsController extends Controller
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

    public function actionIndex()
    {



        return $this->render("/site/index");
    }


    public function actionCreate()
    {

        if (!Yii::$app->arules->isAdmin && !Yii::$app->arules->isSuper) throw new ForbiddenHttpException("Доступ запрещен");

        $thread = new Thread();

        if (Yii::$app->request->isPost && $thread->load(Yii::$app->request->post()) && $thread->save()) {

            // Пересчет дерева `thread`
            Thread::updateTree();

            $this->refresh();
        }


        $parentDataQuery = Thread::find()->where(['thread.active' => 1]);
        $moduleDataQuery = Module::find()->where(['module.active' => 1]);

        if (!Yii::$app->arules->isSuper) { // Для не суперадмина добавляем ограничения
            $parentDataQuery->innerJoin('module', 'module.id = thread.module')->andWhere(['module.create_tree' => 1]);
            $moduleDataQuery->andWhere(['create' => 1]);
        }


//        $parentData = ArrayHelper::map($parentDataQuery->all(), 'id', 'name');

        $pdQ = $parentDataQuery->all();
        $parentData = [];
        foreach ($pdQ as $val) {

            $pad = "";
            for ($i = 0; $i < $val->lvl; $i++) {
                $pad .= "—";
            }
            $parentData[$val->id] = $pad . " " . $val->name;
        }



        return $this->render("create.twig", ['thread' => $thread, 'parentData' => $parentData, 'moduleData' => ArrayHelper::map($moduleDataQuery->all(), 'id', 'name')]);
    }


    public function actionEdit($id)
    {

        if (!Yii::$app->arules->checkUserRule(Yii::$app->user->id, $id, '', 'view')) throw new ForbiddenHttpException("Доступ запрещен");

        $thread = Thread::findOne($id);

        if ($thread === null) {

            throw new NotFoundHttpException('Страница не найдена');
            die();
        }


        $cat = new StructureCat($thread->config);
        $cat->threadId = $thread->id;
        $cat->loadById($thread->id); // Загрузка инфы из таблицы



        // Сохранение данных
        if (Yii::$app->request->isPost && Yii::$app->request->post('StructureCat')) {

            $cat->saveSeo(Yii::$app->request->post());

            $cat->loadData(Yii::$app->request->post());
            $cat->saveData();


            return $this->refresh();
        }

        if (Yii::$app->request->isPost && $thread->load(Yii::$app->request->post()) && $thread->save()) {

            // Пересчет дерева `thread`
            Thread::updateTree();

            return $this->refresh();
        }

        $parentDataQuery = Thread::find()->where(['thread.active' => 1])->andWhere(['<>', 'thread.id', $thread->id]);
        $moduleDataQuery = Module::find()->where(['module.active' => 1]);

        if (!Yii::$app->arules->isSuper) { // Для не суперадмина добавляем ограничения
            $parentDataQuery->innerJoin('module', 'module.id = thread.module')->andWhere(['module.create_tree' => 1])->orWhere(['thread.id' => $thread->parent]);
            $moduleDataQuery->andWhere(['create' => 1])->orWhere(['id' => $thread->module]);
        }


        return $this->render("edit.twig", ['cat' => $cat, 'thread' => $thread, 'parentData' => ArrayHelper::map($parentDataQuery->all(), 'id', 'name'), 'moduleData' => ArrayHelper::map($moduleDataQuery->all(), 'id', 'name')]);
    }


    public function actionDelete($id)
    {


        if (!Yii::$app->arules->checkUserRule(Yii::$app->user->id, $id, '', 'delete')) throw new ForbiddenHttpException("Доступ запрещен");

        $thread = Thread::findOne($id);
        $table = $thread->moduleinfo->controller;
        $model = $thread->model;

        Relations::deleteAll(['table' => 'c_' . $table, 'item_id' => $model->thread_id]);
        Image::deleteAll(['table' => 'c_' . $table, 'item_id' => $model->thread_id]);
        (new Query())->createCommand()->delete('c_' . $table, ['thread_id' => $model->thread_id])->execute();

        // Вложенные разделы переносим на уровень выше и скрываем
        foreach ($thread->childthreads as $val) {
            $val->parent = $thread->parent;
            $val->active = 0;
            $val->save(false);

        }

        $thread->delete();


        return $this->redirect("/admin/threads");
    }








}
