<?php

namespace frontend\controllers;

use common\models\Thread;
use frontend\models\crm\Client;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Statics controller
 */
class StaticsController extends Controller
{

    public function actionIndex($id)
    {

        Yii::$app->params['showClose'] = false;

        $thread = Thread::findOne($id);
        $page = $thread->model;

        if ($page->vimeo) {
            $embedHtml = "<div class=\"work-video__wrapper\">
                <div class=\"content--video\">
                    <div class='embed-overlay'></div>
                    <div class='embed-container'>
                        <iframe src=\"{$page->vimeo}?loop=1&autopause=0\" frameborder=\"0\" allow=\"autoplay; fullscreen\"
                                webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                </div>
            </div>
            ";
            $page->text = str_replace('<p>%video%</p>', '%video%', $page->text);
            $page->text = str_replace('%video%', $embedHtml, $page->text);
        }

        return $this->render('index.twig', [
            'page' => $page,
            'thread' => $thread,
        ]);
    }


    /**
     * @param $id
     * @param $params
     * @throws HttpException
     */
    public function actionView($id, $params)
    {


        throw new HttpException(404, 'Страница не существует');
    }


    public function actionError()
    {

        // Breadcrumbs add
        Yii::$app->params['breadcrumbs'][] = ['label' => "Страница не найдена"];


        return $this->render('error.twig', [
        ]);
    }


}
