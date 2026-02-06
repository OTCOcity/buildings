<?php

namespace frontend\controllers\backup;

use app\models\BBenefit;
use backend\eadmin\config\Language;
use common\models\Thread;
use frontend\components\MiscFunc;
use frontend\models\BObject;
use frontend\models\BVideo;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Video controller
 */
class VideoController extends Controller
{

    /**
     * Список видео
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Objects
        $videos = BVideo::find()->where(['visible' => 1, 'lang' => Language::getDefaultLang(), 'thread_id' => $thread->id])->orderBy(['sort' => SORT_ASC, 'id' => SORT_DESC])->all();

        return $this->render("index.twig", [
            'thread' => $thread,
            'page' => $page,
            'videos' => $videos,
        ]);

    }

    public function actionView($id, $params)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Video
        /** @var BVideo $video */
        $video = BVideo::find()->where(['link' => $params])->one();
        if ($video === null) throw new NotFoundHttpException();

        $video = $video->langData;


        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => $video->name];
        MiscFunc::generateBlockSeo($video);

        return $this->render("view.twig", [
            'thread' => $thread,
            'page' => $page,
            'video' => $video
        ]);
    }


}
