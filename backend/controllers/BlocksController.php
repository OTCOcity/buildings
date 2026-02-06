<?php

namespace backend\controllers;

use backend\eadmin\config\Language;
use backend\models\Relations;
use frontend\components\MiscFunc;
use frontend\models\BCatalogGoods;
use frontend\models\Image;
use Yii;
use backend\eadmin\config\Config;
use backend\models\StructureBlock;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class BlocksController extends Controller
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


        return $this->renderContent("Choose block to edit!");
    }


    public function actionCreate($table, $threadid, $blockkey = "", $blockid = 0)
    {

        if (!Yii::$app->arules->checkUserRule(Yii::$app->user->id, $threadid, $table, 'add')) throw new ForbiddenHttpException("Действие запрещено");

        $block = new StructureBlock(Config::getConfig($table, true));
        $block->threadId = $threadid;
        $block->blockId = $blockid;
        $block->blockKey = $blockkey;
        $insertId = $block->create();

        $this->redirect("/admin/blocks/{$table}/{$insertId}");

    }


    public function actionEdit($table, $id)
    {

        $block = new StructureBlock(Config::getConfig($table, true));
        $result = $block->loadById($id);


        // Редирект на главный блок по языку
        if ($result[0] === 'redirect') {
            return $this->redirect($result[1]);
        }

        // Сохранение данных
        if (Yii::$app->request->isPost && Yii::$app->request->post('StructureBlock')) {

            $block->saveSeo(Yii::$app->request->post());

            $block->loadData(Yii::$app->request->post());


            $block->saveData();


            if ($_POST['saveAndBack']) {
                $this->redirect($_POST['saveAndBack']);
            } else {
                $this->refresh();
            }

        }

        return $this->render("edit.twig", ['block' => $block]);
    }


    public function actionDelete($table, $id)
    {

        $block = new StructureBlock(Config::getConfig($table, true));
        $block->loadById($id);

        if ($block->tab) {
            $tab = "#tab-" . $block->tab;
        }

        if ($block->blockId) {
            $url = "/admin/blocks/{$block->blockKey}/{$block->blockId}" . $tab;
        } else {
            $url = "/admin/threads/{$block->threadId}" . $tab;
        }



        // Delete
        $dq = (new Query)->select('*')->from('b_' . $table)->where(['source_id' => $id, 'thread_id' => $block->thread_id, 'block_id' => $block->block_id, 'block_key' => $block->block_key]);
        foreach ($dq->all() as $b) {
            Relations::deleteAll(['table' => 'b_' . $table, 'item_id' => $b['id']]);
            Image::deleteAll(['table' => 'b_' . $table, 'item_id' => $b['id']]);
            (new Query)->createCommand()->delete('b_' . $table, ['id' => $b['id']])->execute();
        }

        return $this->redirect($url);
    }


    public function actionSortup($table, $id)
    {

        $item = (new Query)->select(['id', 'sort', 'lang', 'thread_id', 'block_id', 'block_key'])->from("b_" . $table)->where(['id' => $id])->one();
        $itemSwap = (new Query)->select(['id', 'sort'])
            ->from("b_" . $table)
            ->where('sort < ' . $item['sort'])
            ->andWhere(['lang' => $item['lang'], 'thread_id' => $item['thread_id'], 'block_id' => $item['block_id'], 'block_key' => $item['block_key'],])
            ->orderBy('sort desc')
            ->one();


        if ($itemSwap['id'] && $item['id']) {
            Yii::$app->db->createCommand("UPDATE `b_{$table}` SET sort = {$item['sort']} WHERE id = {$itemSwap['id']}")->execute();
            Yii::$app->db->createCommand("UPDATE `b_{$table}` SET sort = {$itemSwap['sort']} WHERE id = {$item['id']}")->execute();
        }


    }

    public function actionSortdown($table, $id)
    {
        $item = (new Query)->select(['id', 'sort', 'lang', 'thread_id', 'block_id', 'block_key'])->from("b_" . $table)->where(['id' => $id])->one();
        $itemSwap = (new Query)->select(['id', 'sort'])
            ->from("b_" . $table)
            ->where('sort > ' . $item['sort'])
            ->andWhere(['lang' => $item['lang'], 'thread_id' => $item['thread_id'], 'block_id' => $item['block_id'], 'block_key' => $item['block_key'],])
            ->orderBy('sort asc')
            ->one();

        if ($itemSwap['id'] && $item['id']) {
            Yii::$app->db->createCommand("UPDATE `b_{$table}` SET sort = {$item['sort']} WHERE id = {$itemSwap['id']}")->execute();
            Yii::$app->db->createCommand("UPDATE `b_{$table}` SET sort = {$itemSwap['sort']} WHERE id = {$item['id']}")->execute();
        }
    }

    public function actionVisibletoggle($table, $id)
    {

        $block = new StructureBlock(Config::getConfig($table, true));
        $block->loadById($id);
        $block->visibleToggle();

    }


    /**
     * Изменение мультиселекта из списка блоков (по аяксу)
     */
    public function actionBlockMultiSelectToggleValue()
    {


        if (!Yii::$app->request->isAjax) throw new NotFoundHttpException();

        if ($_POST['table'] && $_POST['key'] && $_POST['item_id'] && isset($_POST['value']) && isset($_POST['toggle'])) {

            Relations::deleteAll(['table' => $_POST['table'], 'key' => $_POST['key'], 'item_id' => $_POST['item_id'], 'value' => $_POST['value']]);

            if ((int)$_POST['toggle']) {

                $relation = new Relations();
                $relation->setAttributes($_POST, false);
                $relation->save(false);

            }

        }


        // To update filters for size and age
        $threadId = array_pop(explode("/", $_SERVER['HTTP_REFERER']));
        $good = new BCatalogGoods();
        $good->thread_id = $threadId;
        MiscFunc::updateGroupSize($good, false);

    }


}
