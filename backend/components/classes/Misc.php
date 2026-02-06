<?php

namespace backend\components\classes;

use backend\eadmin\config\Language;
use common\models\Block;
use common\models\Thread;
use Yii;
use yii\base\Component;
use yii\db\Query;


class Misc extends Component
{


    public function leftNav($parentid = null)
    {

        $navCookie = json_decode($_COOKIE['navOpen']);

        $threadsQuery = Thread::find()->where(['thread.parent' => $parentid])->orderBy('sort');

        if (!Yii::$app->arules->isSuper) { // Для не суперадмина добавляем ограничения
            $threadsQuery->innerJoin('module', 'module.id = thread.module')->andWhere(['module.visible' => 1]);
        }


        $threads = $threadsQuery->all();

        if ($parentid === null) {

            return Yii::$app->view->render('/misc/leftnav.twig', ['threads' => $threads, 'navCookie' => $navCookie]);
        } else {

            return Yii::$app->view->render('/misc/leftnavnest.twig', ['threads' => $threads, 'navCookie' => $navCookie]);
        }
    }

    public static function breadCrumbs()
    {
        $items = [];

        if (Yii::$app->controller->id === 'blocks') {
            $item = Block::getBlockByParams(Yii::$app->controller->actionParams['id'], Yii::$app->controller->actionParams['table']);
            $items[] = ['name' => $item->name, 'url' => '/admin/threads/' . $item->id];
        }

        if (Yii::$app->controller->id === 'threads') {

            $item = Thread::findOne(Yii::$app->controller->actionParams['id']);
            $items[] = ['name' => $item->name, 'url' => '/admin/threads/' . $item->id];
        }


        while (($item = $item->parentObj) !== null) {

            $items[] = isset($item->block_id) ?
                ['name' => $item->name, 'url' => "/admin/blocks/{$item->table}/{$item->id}"] :
                ['name' => $item->name, 'url' => '/admin/threads/' . $item->id];
        }

        $items = array_reverse($items);


        return Yii::$app->view->render('/misc/breadcrumbs.twig', ['items' => $items]);
    }

    public static function getSiteUrl()
    {


        $result = "#";
        if (Yii::$app->controller->id == 'threads' && (int)Yii::$app->controller->actionParams['id']) {

            $thread = (new Query())->select('url')->from('thread')->where(['id' => Yii::$app->controller->actionParams['id']])->one();
            $result = $thread['url'];

        }

        if (Yii::$app->controller->id == 'blocks' && (int)Yii::$app->controller->actionParams['id'] && Yii::$app->controller->actionParams['table']) {

            $blockTable = Yii::$app->db->schema->getTableSchema('b_' . Yii::$app->controller->actionParams['table']);

            if (isset($blockTable->columns['link'])) {
                $flds = "thread_id, link";
            } else {
                $flds = "thread_id";
            }


            $block = (new Query())->select($flds)->from('b_' . Yii::$app->controller->actionParams['table'])->where(['id' => Yii::$app->controller->actionParams['id']])->one();
            $thread = (new Query())->select('url')->from('thread')->where(['id' => $block['thread_id']])->one();
            $result = $thread['url'];

            if ($block['link']) {
                $result .= "/" . $block['link'];
            }

        }

        return trim(Yii::$app->params['siteurl'], "/") . $result;
    }

    public function langNav() {

        $langList = Language::getLanguageList();

//        var_dump(Language::getLangUrl('tr'));
//        die();

        return Yii::$app->view->render('/misc/langNav.twig', ['langList' => $langList]);
    }

}