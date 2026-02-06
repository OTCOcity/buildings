<?php

namespace backend\controllers;

use backend\eadmin\config\Config;
use backend\eadmin\config\Language;
use common\models\Message;
use common\models\Module;
use common\models\SourceMessage;
use common\models\Thread;
use common\models\UserAccess;
use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Translate controller
 */
class TranslateController extends Controller
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

        if (Yii::$app->arules->isEditor) throw new ForbiddenHttpException("Доступ запрещен");


        $translates = SourceMessage::find()->with('messageModel')->all();

        $translateData = [];

        /** @var SourceMessage $tr */
        foreach ($translates as $tr) {

            $messageHash = md5($tr->message);
            if (!isset($translateData[$tr->category][$messageHash])) {
                $translateData[$tr->category][$messageHash] = [];

                $translateData[$tr->category][$messageHash]['default'] = [
                    'id' => $tr->id,
                    'lang' => 'default',
                    'translate' => $tr->message,
                ];
            }

            $translateData[$tr->category][$messageHash][$tr->messageModel->language] = [
                'lang' => $tr->messageModel->language,
                'translate' => $tr->messageModel->translation,
            ];


        }

//        echo "<pre>";
//        var_export($translateData);
//        echo "</pre>";

        return $this->render('index.twig', [
            'translateData' => $translateData
        ]);
    }


    public function actionDelete($id)
    {

        $smDefault = SourceMessage::findOne($id);
        $smList = SourceMessage::find()->where([
            'category' => $smDefault->category,
            'message' => $smDefault->message,
        ])->all();


        $idList = [];
        foreach ($smList as $sm) {
            $idList[] = $sm->id;
        }

        SourceMessage::deleteAll(['in', 'id', $idList]);
        Message::deleteAll(['in', 'id', $idList]);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $smDefault->attributes;

    }


    public function actionEdit($id)
    {

        $smDefault = SourceMessage::findOne($id);
        if ($smDefault === null) {
            $smDefault = new SourceMessage();
        }

        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {

            $response = [];
            $response['isNewRecord'] = $smDefault->isNewRecord;

            $post = Yii::$app->request->post();

            // Validation Empty phrase
            if (!trim($post['translate'][Language::getDefaultLang()])) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['error' => true, 'message' => 'Фраза для перевода не может быть пустой!'];
            }

            // Validation Check duplicates
            if ($smDefault->isNewRecord || $smDefault->category !== $post['translate']['category'] || $smDefault->message !== $post['translate'][Language::getDefaultLang()]) {
                $duplicateExist = SourceMessage::find()
                    ->where([
                        'category' => $post['translate']['category'],
                        'message' => $post['translate'][Language::getDefaultLang()],
                    ])
                    ->exists();

                if ($duplicateExist) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['error' => true, 'message' => 'Данная фраза в этой категории уже существует!'];
                }
            }

            // Save new Source Message
            if ($smDefault->isNewRecord) {
                $smDefault->category = $post['translate']['category'];
                $smDefault->message = $post['translate'][Language::getDefaultLang()];
            }

            // Response category
            $response['data'] = [$post['translate']['category'],];

            foreach (Language::getLanguageListDefaultSort() as $key => $lang) {

//                if ($lang['default']) continue;

                $response['data'][$key + 1] = '';

                $sm = SourceMessage::findByLang($smDefault->category, $smDefault->message, $lang['name']);


                // Delete on empty translate
                if ($post['translate'][$lang['name']] === '') {
                    if ($sm !== null) {
                        $sm->delete();
                    }
                    continue;
                }


                // Save SourceMessage
                if ($sm === null) {
                    $sm = new SourceMessage();
                }
                $sm->category = $post['translate']['category'];
                $sm->message = $post['translate'][Language::getDefaultLang()];
                $sm->save(false);

                // Default id (default language)
                if ($key === 0) {
                    $response['id'] = $sm->id;
                }

                // Save Message
                $m = $sm->messageModel;
                if ($m === null) {
                    $m = new Message();
                }
                $m->id = $sm->id;
                $m->language = $lang['name'];
                $m->translation = $post['translate'][$lang['name']];
                $m->save(false);

                $response['data'][$key + 1] = $post['translate'][$lang['name']];
            }

            // Add last controls td
            $response['data'][] = '<a class="green translate-block-edit" data-id="' . $response['id'] . '" href="#"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;<a class="red translate-block-delete translate-block-delete--' . $response['id'] . '" data-id="' . $response['id'] . '" href="#"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>';


            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }


        $smList = SourceMessage::find()->with('messageModel')->where([
            'category' => $smDefault->category,
            'message' => $smDefault->message,
        ])->all();

        $translateData = [
            Language::getDefaultLang() => $smDefault->message
        ];
        /** @var SourceMessage $sm */
        foreach ($smList as $sm) {
            $translateData[$sm->messageModel->language] = $sm->messageModel->translation;
        }


        return $this->renderPartial('edit.twig', [
            'categoryDefault' => $smDefault->category ? $smDefault->category : Language::getCategoryList()[0],
            'translateData' => $translateData
        ]);
    }
}
