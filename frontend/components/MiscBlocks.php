<?php

namespace frontend\components;

use common\models\Thread;
use frontend\models\CMain;
use frontend\models\forms\FeedbackForm;
use Yii;

class MiscBlocks
{

    static public function pageClose()
    {

        return Yii::$app->view->render("/misc_blocks/page_close.twig");
    }

    static public function feedbackPopup()
    {
        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        $feedbackForm = new FeedbackForm();

        return Yii::$app->view->render("/misc_blocks/feedback_popup.twig", [
            'options' => $options,
            'feedbackForm' => $feedbackForm
        ]);
    }

    static public function feedbackInline($title = 'Начать проект', $text = '', $topMargin = 'big')
    {
        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        $feedbackForm = new FeedbackForm();
        $feedbackForm->text = $text;

        return Yii::$app->view->render("/misc_blocks/feedback_inline.twig", [
            'options' => $options,
            'feedbackForm' => $feedbackForm,
            'title' => $title,
            'text' => $text,
            'topMargin' => $topMargin,
        ]);
    }

    static public function mainLogo($class = '')
    {
        $logoArr = str_split(CMain::find()->one()->text_main);

        return Yii::$app->view->render("/misc_blocks/main_logo.twig", ['logoArr' => $logoArr, 'class' => $class]);
    }

    static public function pageHead($title, $subtitle, $color, $imagePath)
    {

        return Yii::$app->view->render("/misc_blocks/page_head.twig", [
            'color' => $color,
            'title' => $title,
            'subtitle' => $subtitle,
            'imagePath' => $imagePath,
        ]);
    }

    static public function picture($srcs, $class, $sizes = ['big', 'medium', 'small'], $title = '', $alt = '')
    {

        if (!is_array($srcs)) {
            $srcs = [$srcs];
        }
        foreach ($sizes as $key => $size) {
            if (!isset($srcs[$key])) {
                $srcs[$key] = $srcs[count($srcs) - 1];
            }
        }

        return Yii::$app->view->render('/misc_blocks/picture.twig', [
            'class' => $class,
            'sizes' => $sizes,
            'medias' => [1400, 640],
            'srcs' => $srcs,
            'alt' => $alt,
            'title' => $title,
        ]);
    }
    public function breadcrumbs()
    {

        return Yii::$app->view->render('/misc_blocks/_breadcrumbs.twig');
    }

    static public function title()
    {


        $bc = Yii::$app->params['breadcrumbs'];
        $lastBc = array_pop($bc);

        $title = Yii::$app->name;


        if (Yii::$app->params['seo_title']) {

            // $title = Yii::$app->params['seo_title'] . " - " . $title;
            $title = Yii::$app->params['seo_title'];

        } else if ($lastBc['label'] && $lastBc['url'] != '/') {

            // $title = $lastBc['label'] . " - " . $title;
            $title = $lastBc['label'];
        }


        return "<title>{$title}</title>";
    }

    static public function keywords()
    {


        return Yii::$app->view->render("/misc_blocks/keywords.twig", ['keywords' => Yii::$app->params['seo_keywords']]);
    }

    static public function description()
    {

        return Yii::$app->view->render("/misc_blocks/description.twig", ['description' => Yii::$app->params['seo_description']]);
    }

    static public function header()
    {

        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        // Разделы
        $threads = Thread::find()->where(['lvl' => 0, 'active' => 1, 'inmenu' => 1])->orderBy('sort')->all();


        return Yii::$app->view->render('/misc_blocks/header.twig',
            [
                'options' => $options,
                'threads' => $threads
            ]
        );
    }

    static public function menu($showTitle = true, $showBurger = true)
    {

        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        // Разделы
        $threads = Thread::find()->where(['lvl' => 0, 'active' => 1, 'inmenu' => 1])->orderBy('sort')->all();

        // Work Groups
//        $groupsQuery = (new Query())->select(['group', 'count(*) as cnt'])
//            ->from('b_work')
//            ->where(['visible' => 1])
//            ->orderBy(['group' => SORT_ASC])
//            ->groupBy('group');

//        if (Yii::$app->controller->id === 'catalog') {
//            $groupsQuery->andWhere(['thread_id' => Yii::$app->controller->actionParams['id']]);
//        } else {
//            $groupsQuery->andWhere(['thread_id' => Yii::$app->params['workThreadId']]);
//        }

//        $groups = $groupsQuery->all();
//
//        // Work count
//        $workTotal = array_reduce($groups, function ($a, $g) {
//            $a = $a + $g['cnt'];
//            return $a;
//        });

//        var_dump(Yii::$app->controller->id);
//        var_dump(Yii::$app->controller->action->id);
//        var_dump(Yii::$app->controller->actionParams);die();
//
        // Presentation
//        $presUrl = false;
//        $mainPageInfo = CMain::find()->one();
//        $presFile = $mainPageInfo->image;
//        if ($mainPageInfo->title) {
//            $presWork = BWork::findOne(['name' => $mainPageInfo->title]);
//            if ($presWork !== null) {
//                $presUrl = $presWork->url;
//            }
//        }
//


        return Yii::$app->view->render('/misc_blocks/menu.twig',
            [
                'showTitle' => $showTitle,
                'showBurger' => $showBurger,
                'options' => $options,
                'threads' => $threads,
//                'groups' => $groups,
//                'workTotal' => $workTotal,
//                'presFile' => $presFile,
//                'presUrl' => $presUrl,
            ]
        );
    }

    static public function fbBlock()
    {
        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        return Yii::$app->view->render('/misc_blocks/fb_block.twig', [
            'options' => $options,
        ]);
    }

    static public function contacts()
    {

        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        // Разделы
//        $threads = Thread::find()->where(['lvl' => 0, 'active' => 1, 'inmenu' => 1])->with('childMenuthreads')->orderBy('sort')->all();

        return Yii::$app->view->render('/misc_blocks/contacts.twig', [
            'options' => $options,
//                'threads' => $threads,
        ]);
    }

    static public function footer()
    {
        $options = MiscFunc::getThreadData('options');

        return Yii::$app->view->render('/misc_blocks/footer.twig', [
            'options' => $options,
        ]);
    }

    static public function pageContacts()
    {

        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        return Yii::$app->view->render('/misc_blocks/page_contacts.twig', [
            'options' => $options,
        ]);
    }

}