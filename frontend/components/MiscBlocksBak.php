<?php

namespace frontend\components;

use common\models\Thread;
use frontend\models\BCatalogGoods;
use frontend\models\BNews;
use frontend\models\BServices;
use frontend\models\BStandart;
use frontend\models\CCart;
use frontend\models\forms\CallForm;
use frontend\models\forms\FeedbackForm;
use Yii;
use yii\db\Query;

class MiscBlocks
{

    public function title()
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

    public function keywords()
    {


        return Yii::$app->view->render("/misc_blocks/keywords.twig", ['keywords' => Yii::$app->params['seo_keywords']]);
    }

    public function description()
    {

        return Yii::$app->view->render("/misc_blocks/description.twig", ['description' => Yii::$app->params['seo_description']]);
    }


    static public function menu()
    {

        $threads = Thread::find()->where(['lvl' => 0, 'active' => 1, 'inmenu' => 1])->with('childMenuthreads')->all();
        $cartCount = count($_SESSION['cart']);


        return Yii::$app->view->render("/misc_blocks/menu.twig", ['threads' => $threads, 'cartCount' => $cartCount]);
    }


    static public function icons()
    {

        return Yii::$app->view->render("/misc_blocks/icons.twig");
    }

    static public function head()
    {

        $standarts = BStandart::find()->select('name as label')->where(['visible' => 1])->asArray()->all();


        return Yii::$app->view->render("/misc_blocks/head.twig", [
            'standarts' => $standarts,
        ]);
    }


    /**
     * Список услуг
     * @return string
     */
    public function services($services, $title, $text)
    {

        return Yii::$app->view->render('/misc_blocks/services.twig',
            [
                'title' => $title,
                'text' => $text,
                'services' => $services,
            ]
        );
    }


    /**
     * Верхнее большое изображение
     * @return string
     */
    public function banner($image, $title, $text)
    {

        return Yii::$app->view->render('/misc_blocks/banner.twig',
            [
                'image' => $image,
                'title' => $title,
                'text' => $text,
            ]
        );
    }

    /**
     * Подвал
     * @return РЕЖИМ РАБОТЫ
     * string
     */
    public function footer()
    {

        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        // Разделы
        $threads = Thread::find()->where(['lvl' => 0, 'active' => 1, 'inmenu' => 1])->with('childMenuthreads')->orderBy('sort')->all();

        return Yii::$app->view->render('/misc_blocks/footer.twig', [
            'options' => $options,
            'threads' => $threads,
        ]);
    }


    /**
     * Header
     * @return string
     */
    public function header()
    {

        // Опции сайта
        $options = MiscFunc::getThreadData('options');

        // Разделы
        $threads = Thread::find()->where(['lvl' => 0, 'active' => 1, 'inmenu' => 1])->with('childMenuthreads')->orderBy('sort')->all();

        return Yii::$app->view->render('/misc_blocks/header.twig',
            [
                'options' => $options,
                'threads' => $threads
            ]
        );
    }


    public function lastNews($thread)
    {

        // LastNews
        $lastNews = BNews::find()
            ->with('source')
            ->where(['thread_id' => $thread->id, 'visible' => 1])
            ->andWhere(['lang' => Yii::$app->language])
            ->orderBy('date desc')
            ->limit(3)
            ->all();


        return Yii::$app->view->render('/misc_blocks/last_news.twig', [
            'lastNews' => $lastNews,
        ]);
    }

    public function newsCategories($thread)
    {

        $categories = (new Query())
            ->select('count(*) cnt, group')
            ->where(['thread_id' => $thread->id, 'lang' => Yii::$app->language])
            ->from('b_news')
            ->groupBy('group')
            ->all();


        return Yii::$app->view->render('/misc_blocks/news_categories.twig', [
            'categories' => $categories,
            'thread' => $thread,
        ]);
    }


    public function headerSearch() {

        return Yii::$app->view->render('/misc_blocks/header_search.twig', []);
    }

    public function headerImage($title, $imageSrc = false) {

        return Yii::$app->view->render('/misc_blocks/header_image.twig', [
            'title' => $title,
            'imageSrc' => $imageSrc
        ]);
    }

    /**
     * Header small
     * @return string
     */
    public function headerSmall()
    {


        return Yii::$app->view->render('/misc_blocks/header_small.twig', []);
    }


    /**
     * Call block (like in news)
     * @return string
     */
    public function callBlock()
    {

        $options = MiscFunc::getThreadData('options');

        return Yii::$app->view->render('/misc_blocks/call_block.twig', ['options' => $options]);
    }

    /**
     * Share block (like in news)
     * @return string
     */
    public function shareBlock($url = "", $title = "", $image = "", $description = "")
    {


        return Yii::$app->view->render('/misc_blocks/share_block.twig', ['url' => $url, 'title' => $title, 'image' => $image, 'description' => $description]);
    }


    /**
     * Страницы
     * int $page - текущая страница
     * int $count - всего страниц
     * string $url - адрес страницы
     * @return string
     */
    public function pagination($page, $count, $url, $filterQuery)
    {

        $prevPage = $page - 1;
        $nextPage = $page + 1;

        if ($page < 1) $page = 1;
        if ($page > $count) $page = $count;

        if ($count < 2) return "";


        $pages = [1, '...', $page - 1, $page, $page + 1, '...', (int)$count];
        $pagesFormatted = [];
        $maxP = 0;
        foreach ($pages as $key => $p) {

            if ((is_int($p) && $p > $maxP)) {
                $maxP = $p;

                if ($maxP <= $count) {
                    $pagesFormatted[] = $maxP;
                }
            }
            if ($p === '...') {
                $pagesFormatted[] = $p;
            }


        }


        $pageSize = count($pagesFormatted);
        foreach ($pagesFormatted as $key => $p) {

            if ($p === '...') {
                if ($pagesFormatted[$key + 1] == $pagesFormatted[$key - 1] + 1 || $key + 1 == $pageSize) {
                    unset($pagesFormatted[$key]);
                }
            }


        }


        return Yii::$app->view->render('/misc_blocks/_pagination.twig', [
            'pages' => $pagesFormatted,
            'activePage' => $page,
            'count' => $count,
            'url' => $url,
            'filterQuery' => $filterQuery,
        ]);
    }


    /**
     * Страницы
     * int $page - текущая страница
     * int $count - всего страниц
     * string $url - адрес страницы
     * @return string
     */
    public function breadcrumbs()
    {

        return Yii::$app->view->render('/misc_blocks/_breadcrumbs.twig');
    }


    /**
     * Выпадающая корзина
     */
    static public function cartHeader()
    {

        $cart = new CCart();

        return Yii::$app->view->render('/cart/__cart_header.twig', [
            'items' => $cart->items,
            'sum' => $cart->sum,
        ]);
    }


    /**
     * Модалки
     */
    public function modals()
    {


        $callForm = new CallForm();
        $feedbackForm = new FeedbackForm();


        $osUrl = MiscFunc::getThreadInfo('form', 'url');

        return Yii::$app->view->render('/misc_blocks/modals.twig', ['callForm' => $callForm, 'feedbackForm' => $feedbackForm, 'osUrl' => $osUrl]);
    }


    /**
     * Catalog history
     * @return string
     */
    public function history()
    {

        if (!is_array($_SESSION['catalog_history'])) $_SESSION['catalog_history'] = [];

        $goods = BCatalogGoods::find()->where(['visible' => 1])->andWhere(['in', 'id', $_SESSION['catalog_history']])->all();


        return Yii::$app->view->render('/misc_blocks/history.twig', ['goods' => $goods]);
    }

    /**
     * Navigation
     * @return string
     */
    public function nav()
    {

        $threads = Thread::find()->where(['active' => 1, 'lvl' => 0, 'inmenu' => 1])->orderBy('sort')->all();

        return Yii::$app->view->render('/misc_blocks/nav.twig', ['threads' => $threads]);
    }

    /**
     * Навигация каталога первого уровня
     */
    public function catNavFirst()
    {

        $threads = Thread::find()->where(['active' => 1, 'module' => 10, 'parent' => MiscFunc::getThreadInfo('catalog', 'id')])->orderBy('sort')->all();


        return Yii::$app->view->render('/misc_blocks/cat_nav_first.twig', [
            'threads' => $threads,
            'sideClass' => in_array(Yii::$app->controller->id, ['main', 'catalog_group']) && Yii::$app->controller->action->id == 'index' || Yii::$app->controller->id == 'statics' ? "" : "product_sidebar"
        ]);
    }


    /**
     * Навигация каталога ниже первого уровня
     */
    public function catNavSecond($group)
    {


        // Верхние разделы в select
        $threads = Thread::find()->where(['active' => 1, 'module' => 10, 'parent' => MiscFunc::getThreadInfo('catalog', 'id')])->orderBy('sort')->all();


        return Yii::$app->view->render('/misc_blocks/cat_nav_second.twig', ['threads' => $threads]);
    }


    /**
     * Рекламные блоки
     */
    public function advent($item = null)
    {

        if ($item != null) {

            $advents = $item->getAdvs()->where(['desktop' => 0])->all();
        }


        return Yii::$app->view->render('/misc_blocks/advent.twig', ['advents' => $advents]);
    }

    public function adventTop($item = null)
    {

        if ($item != null) {

            $advents = $item->getAdvs()->where(['desktop' => 1])->all();
        }


        return Yii::$app->view->render('/misc_blocks/advent.twig', ['advents' => $advents]);
    }


    /**
     * Бэкграунд левый
     */
    public function leftBg()
    {

        $bgClass = "jobs-bg";

        if (Yii::$app->controller->id == "cart") {

            $bgClass = "cart-bg";
        }

        return Yii::$app->view->render('/misc_blocks/left_bg.twig', ['bgClass' => $bgClass]);
    }


    public function catalogTree($id)
    {

        $threadItems = Thread::find()->where(['active' => 1, 'parent' => $id])->orderBy('sort')->all();

        $goodItems = BCatalogGoods::find()->where(['visible' => 1, 'thread_id' => $id])->orderBy('sort')->all();

        $items = array_merge($threadItems, $goodItems);

        // $items = $threadItems;

        return Yii::$app->view->render('/misc_blocks/catalog_tree.twig', ['items' => $items]);

    }


    public function productSale($sale)
    {

        return Yii::$app->view->render('/misc_blocks/product_sale.twig', ['sale' => $sale]);
    }


    
}