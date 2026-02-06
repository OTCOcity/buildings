<?php

namespace frontend\controllers\backup;

use frontend\components\MiscFunc;
use frontend\models\BCatalogGoods;
use frontend\models\BStandart;
use frontend\models\BSubStandart;
use frontend\models\FilterAge;
use frontend\models\FilterSize;
use Yii;
use app\models\BBenefit;
use common\models\Thread;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Standart controller
 */
class StandartController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
//                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Список стандартов.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        // AccessControl
        if (Yii::$app->user->isGuest) $this->redirect('/login');


        $thread = Thread::findOne($id);
        $standart = $thread->model;

        MiscFunc::generateBlockSeo($standart);


        // Группируем стандарты

        $standartsByGroups = [];
        foreach ($standart->standarts as $standart) {
            $grouphash = md5($standart->group);
            if (!isset($standartsByGroups[$grouphash])) {
                $standartsByGroups[$grouphash] = (object)[
                    'name' => $standart->group,
                    'items' => [],
                ];
            }
            $standartsByGroups[$grouphash]->items[] = $standart;
        }

        // Breadcrumbs
        Yii::$app->params['breadcrumbs'][] = ['label' => "Стандарты"];

        return $this->render("index.twig", [
            'thread' => $thread,
            'standartsByGroups' => $standartsByGroups,
        ]);
    }


    public function actionView($id, $params)
    {

        $paramsArr = explode("/", $params);


        // View for pdf without AccessControl
        if (isset($_GET['pdf'])) {
            return $this->actionViewForPdf($id, $paramsArr);
        }


        // AccessControl
        if (Yii::$app->user->isGuest) $this->redirect('/login');

        // Print image
        if ($paramsArr[0] === 'images' && $paramsArr[1] === 'print' && $paramsArr[2] && $paramsArr[3]) {
            return $this->printImage($paramsArr[2], $paramsArr[3]);
        }

        // Download image
        if ($paramsArr[0] === 'images' && $paramsArr[1] === 'download' && $paramsArr[2] && $paramsArr[3]) {
            return $this->downloadImage($paramsArr[2], $paramsArr[3]);
        }


        // Download pdf flag
        $downloadPdf = false;
        if (strpos($paramsArr[0], ".pdf")) {

            $paramsArr[0] = str_replace(".pdf", "", $paramsArr[0]);
            $downloadPdf = true;
        }


        $thread = Thread::findOne($id);
        $page = $thread->model;


        $standart = BStandart::find()->where(['visible' => 1, 'link' => $paramsArr[0]])->one();

        if ($standart === null) throw new NotFoundHttpException();


        // Breadcrumbs add
//        Yii::$app->params['breadcrumbs'][] = ['label' => $good->name, 'url' => $good->url];


        // Menu items
        Yii::$app->params['standartItems'] = [];
        foreach ($standart->subStandarts as $subStandart) {
            $subItem = [
                ['name' => $subStandart->name, 'hash' => 'standart' . $subStandart->id],
            ];

            if (count($subStandart->techs)) {
                $subItem[] = ['name' => 'Технологическая карта', 'hash' => 'tech' . $subStandart->id];
            }

            if ($subStandart->spec_text) {
                $subItem[] = ['name' => $subStandart->spec_title ? $subStandart->spec_title : 'Спецификация', 'hash' => 'spec' . $subStandart->id];
            }

            if ($subStandart->exp_text) {
                $subItem[] = ['name' => 'Расход материалов', 'hash' => 'exp' . $subStandart->id];
            }

            if (count($subStandart->extraSchemas)) {
                $subItem[] = ['name' => 'Чертежи и схемы', 'hash' => 'es' . $subStandart->id];
            }

            array_push(Yii::$app->params['standartItems'], $subItem);
        }

        if ($standart->check_text) {
            array_push(Yii::$app->params['standartItems'], [['name' => "Чек-лист", 'hash' => 'checklist']]);
        }
        if (count($standart->calendars)) {
            array_push(Yii::$app->params['standartItems'], [['name' => "Календарь работ", 'hash' => 'calendar']]);
        }


        // Seo
        MiscFunc::generateBlockSeo($standart);


//        var_dump($standart->attributes);
//        var_dump($standart->calendars);
//        die();


        // Old download (from admin)
        $filePath = Yii::getAlias('@frontend/web/upload/orig/' . $standart->file);
        if ($paramsArr[1] === 'download' && $standart->file && file_exists($filePath)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Disposition:attachment;filename*=UTF-8''" . rawurlencode($standart->name . '.' . array_pop(explode(".", $standart->file))));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;

        }


        // Download url
        $urlParsed = parse_url(Yii::$app->request->url);
        $urlPath = $urlParsed['path'];
        if (is_file(Yii::getAlias("@frontend/web/upload/pdf/{$standart->id}/{$standart->md5Hash}.pdf"))) {
            Yii::$app->params['standartDownloadUrl'] = $urlPath . '.pdf';
        }

        // Download tcpdf
        if ($downloadPdf) {


            if (!$standart->pdfFileExists) {


                throw new NotFoundHttpException();

            }

            $pdfDir = \Yii::getAlias("@frontend/web/upload/pdf/{$standart->id}");

            $filePath = $pdfDir . '/' . $standart->md5Hash . '.pdf';

            ob_start();
//            header("Content-Disposition:attachment;filename*=UTF-8''" . rawurlencode("{$standart->name}.pdf"));
            header("Content-type:application/pdf");
            header('Content-Length: ' . filesize($filePath));

            readfile($filePath);
            exit(0);

        } else {

            $this->layout = "standart.twig";

            return $this->render("view.twig", [
                'thread' => $thread,
                'page' => $page,
                'standart' => $standart,
                'isPdf' => false
            ]);
        }
    }


    public function printImage($image, $title)
    {

        $this->layout = "print-image.twig";

        Yii::$app->params['breadcrumbs'] = [['label' => $title]];

        return $this->render('image.twig', [
            'image' => $image,
            'title' => $title
        ]);
    }

    public function downloadImage($image, $title)
    {
        $file = \Yii::getAlias('@frontend/web/upload/orig/') . $image;
        if (is_file($file)) {

            $fileSize = filesize($file);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Disposition:attachment;filename*=UTF-8''" . rawurlencode($title . '.' . array_pop(explode(".", $image))));
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $fileSize);

            readfile($file);

        } else {
            throw new NotFoundHttpException();
        }
    }


    // Pdf
    public function actionViewForPdf($id, $paramsArr)
    {
        if (!in_array(Yii::$app->request->getUserIP(), Yii::$app->params['pdfGenerateIpList'])) {
            return "Access deny for " . Yii::$app->request->getUserIP();
        }

        $thread = Thread::findOne($id);
        $page = $thread->model;


        $standart = BStandart::find()->where(['visible' => 1, 'link' => $paramsArr[0]])->one();

        if ($standart === null) throw new NotFoundHttpException();

        $this->layout = 'standart_pdf.twig';



        // Обложка
        if (isset($_GET['title'])) {
            return $this->render("/standart_pdf/blocks/header.twig", [
                'thread' => $thread,
                'page' => $page,
                'standart' => $standart,
            ]);
        }

        if (isset($_GET['checklist'])) {
            return $this->render("/standart_pdf/blocks/checklist.twig", [
                'thread' => $thread,
                'page' => $page,
                'standart' => $standart,
            ]);
        }

        if (isset($_GET['calendar'])) {
            return $this->render("/standart_pdf/blocks/calendar.twig", [
                'thread' => $thread,
                'page' => $page,
                'standart' => $standart,
            ]);
        }

        if (isset($_GET['description']) && (int)$_GET['subId']) {
            $subStandart = BSubStandart::findOne((int)$_GET['subId']);
            if ($subStandart) {
                return $this->render("/standart_pdf/blocks/description.twig", [
                    'thread' => $thread,
                    'page' => $page,
                    'standart' => $standart,
                    'subStandart' => $subStandart,
                ]);
            } else {
                return '';
            }
        }

        if (isset($_GET['rash']) && (int)$_GET['subId']) {
            $subStandart = BSubStandart::findOne((int)$_GET['subId']);
            if ($subStandart) {
                $result = $this->renderPartial("/standart_pdf/blocks/spec.twig", [
                    'thread' => $thread,
                    'page' => $page,
                    'standart' => $standart,
                    'subStandart' => $subStandart,
                ]);
                $result .= $this->renderPartial("/standart_pdf/blocks/rash.twig", [
                    'thread' => $thread,
                    'page' => $page,
                    'standart' => $standart,
                    'subStandart' => $subStandart,
                ]);
                return $this->renderContent($result);
            } else {
                return '';
            }
        }


        if (isset($_GET['techimages']) && (int)$_GET['subId']) {
            $subStandart = BSubStandart::findOne((int)$_GET['subId']);
            if ($subStandart) {
                return $this->render("/standart_pdf/blocks/tech_images.twig", [
                    'thread' => $thread,
                    'page' => $page,
                    'standart' => $standart,
                    'subStandart' => $subStandart,
                ]);
            } else {
                return '';
            }
        }



        return $this->render("/standart_pdf/view.twig", [
            'thread' => $thread,
            'page' => $page,
            'standart' => $standart,
        ]);
    }

}
