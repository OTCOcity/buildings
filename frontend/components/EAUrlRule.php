<?php

namespace frontend\components;

use backend\eadmin\config\Language;
use common\models\Thread;
use frontend\models\BSeoFilter;
use Yii;
use yii\web\UrlRuleInterface;

class EAUrlRule implements UrlRuleInterface
{
    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param \yii\web\UrlManager $manager the URL manager
     * @param \yii\web\Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     * @throws
     */
    public function parseRequest($manager, $request)
    {

        $pathInfo = $request->getPathInfo();
        $url = $request->url;
        $params = [];



        // Check language
        if (Yii::$app->params['languageList']) {
            $language = Language::getDefaultLang();
            foreach (Yii::$app->params['languageList'] as $lang) {
                if (preg_match("/^{$lang['name']}\//ui", $pathInfo) || $pathInfo == $lang['name']) {
                    $language = $lang['name'];
                    break;
                }
            }

            if ($language === false) {

                $defaultLanguage = $_SESSION['lang'] ? $_SESSION['lang'] : ($_COOKIE['lang'] ? $_COOKIE['lang'] : Language::getDefaultLang());
                $redirectUrl = rtrim("/{$defaultLanguage}/{$pathInfo}", '/');
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: {$redirectUrl}");
                exit();
            }

            $_SESSION['lang'] = $language;
            $_COOKIE['lang'] = $language;

            Yii::$app->language = $language;

            $pathInfo = preg_replace("/^{$language}\/?/ui", '', $pathInfo);
            $url = preg_replace("/^\/{$language}\/?/ui", '', $url);
        }

        $parameters = explode('/', $pathInfo);

        // Ищем по Thread
        $path = "";
        $lastThread = "";
        foreach ($parameters as $paramentr) {

            $path .= "/" . $paramentr;

            if ($thread = Thread::findOne(['url' => $path, 'active' => 1])) {

                $lastThread = clone $thread;

                Yii::$app->params['breadcrumbs'][] = ['label' => $thread->name, 'url' => $thread->url];

            } else {

                $params[] = $paramentr;
            }

        }

        if (count($params)) {

            $actionArr = explode('-', $params[0]);
            $action = '';
            foreach ($actionArr as $actionWord) {
                $action .= ucfirst($actionWord);
            }
            $action = 'action' . $action;

            if (method_exists("frontend\controllers\\" . ucfirst($lastThread->moduleinfo->controller) . 'Controller', $action)) {
                $paramAction = array_shift($params);
                $route = $lastThread->moduleinfo->controller . '/' . $paramAction;
            } else {
                $route = $lastThread->moduleinfo->controller . "/view";
            }

        } else {
            $route = $lastThread->moduleinfo->controller . "/index";
        }


        // Ищем по файлам Controllers
        if (!$lastThread) {


            $controllerClass = 'frontend\controllers\\' . ucfirst($parameters[0]) . 'Controller';
            $controllerAction = $parameters[1] ? 'action' . ucfirst($parameters[1]) : 'actionIndex';

            if (method_exists($controllerClass, $controllerAction)) {

//                var_dump([$parameters[0] . '/' . $parameters[1], ['params' => $params]]);die();
                return [$parameters[0] . '/' . $parameters[1], ['params' => implode("/", $params)]];
            }
//            var_dump($parameters);
//            die();

        }

        // Seo info to params
        $model = $lastThread->model;
        if (Yii::$app->params['seo_filter']) {
            Yii::$app->params['seo_title'] = Yii::$app->params['seo_filter']->name;
            Yii::$app->params['seo_keywords'] = Yii::$app->params['seo_filter']->keywords;
            Yii::$app->params['seo_description'] = Yii::$app->params['seo_filter']->description;
        } else if ($model) {
            if ($model->hasAttribute('seo_title')) Yii::$app->params['seo_title'] = $model->seo_title;
            if ($model->hasAttribute('seo_keywords')) Yii::$app->params['seo_keywords'] = $model->seo_keywords;
            if ($model->hasAttribute('seo_description')) Yii::$app->params['seo_description'] = $model->seo_description;
        }

//        Yii::trace("Request parsed with URL ea rule", __METHOD__);

//
//        var_dump($route);
//        var_dump($lastThread->id);
//        var_dump(implode("/", $params));
//        die();


        return [$route, ['id' => $lastThread->id, 'params' => implode("/", $params)]];
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param \yii\web\UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {


        /*
        if ($route !== 'site/jobs') {
            return false;
        }
        //If a parameter is defined and not empty - add it to the URL
        $url = 'jobs/';
        if (array_key_exists('category', $params) && !empty($params['category'])) {
            $url .= $params['category'];
        }
        if (array_key_exists('subcategory', $params) && !empty($params['subcategory'])) {
            $url .= ',' . $params['subcategory'];
        }
        if (array_key_exists('state', $params) && !empty($params['state'])) {
            $url .= '/' . $params['state'];
        }
        if (array_key_exists('city', $params) && !empty($params['city'])) {
            $url .= ',' . $params['city'];
        }
        if (array_key_exists('page', $params) && !empty($params['page'])) {
            $url .= '/' . $params['page'];
        }
        */


        return $route;
    }
}