<?php

namespace frontend\controllers\backup;

use frontend\components\MiscFunc;
use Yii;
use common\models\Thread;
use frontend\models\BNews;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\db\Expression;

/**
 * News controller
 */
class NewsController extends Controller
{

    public $pageLimit = 4;

    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $info = $thread->model;

        $query = BNews::find()
            ->with('source')
            ->where(['thread_id' => $info->thread_id, 'visible' => 1])
            ->andWhere(['lang' => Yii::$app->language])
            ->orderBy('date desc');

        // Search
        if ($search = trim($_GET['search'])) {
            if (mb_strlen($search, 'utf-8') > 2) {
                $query->andWhere(['like', 'name', $search]);
            }
        }

        // Category
        if ($category = trim($_GET['category'])) {
            $query->andWhere(['group' => $category]);
        }

        $news = $query->all();

        // LastNews
//        $lastNews = BNews::find()
//            ->with('source')
//            ->where(['thread_id' => $info->thread_id, 'visible' => 1])
//            ->andWhere(['lang' => Yii::$app->language])
//            ->orderBy('date desc')
//            ->limit(3)
//            ->all();


        return $this->render('index.twig', [
            'info' => $info,
            'thread' => $thread,
            'news' => $news,
//            'lastNews' => $lastNews,
        ]);
    }


    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $info = $thread->model;


        $paramsArr = explode("/", $params);
        if (count($paramsArr) > 1) throw new ForbiddenHttpException;

        $new = BNews::find()
            ->leftJoin('b_news bn', 'bn.id = b_news.source_id')
            ->where(['bn.link' => $paramsArr[0], 'bn.thread_id' => $thread->id, 'b_news.lang' => Yii::$app->language])
            ->one();

        if ($new === null) throw new ForbiddenHttpException;

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $new->name];
        MiscFunc::generateBlockSeo($new);

        return $this->render('view.twig', [
            'info' => $info,
            'thread' => $thread,
            'new' => $new,
        ]);

    }


}
