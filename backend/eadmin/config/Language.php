<?php

namespace backend\eadmin\config;

/**
 * Language Class
 */
class Language
{

    static private $_isDefault = null;

    static public $_langShortList;

    static public $categoryList = [
        'app',
        'buttons',
        'menu'
    ];


    static public function getLangShortList() {

        if (!self::$_langShortList) {
            self::$_langShortList = [];
            foreach (\Yii::$app->params['languageList'] as $lang) {
                self::$_langShortList[] = $lang['name'];
            }
        }

        return self::$_langShortList;
    }

    static public function getCategoryList() {
        return self::$categoryList;
    }

    static public function getLanguageList() {
        return \Yii::$app->params['languageList'];
    }

    static public function getLanguageListDefaultSort() {
        $langList = \Yii::$app->params['languageList'];
        usort($langList, function($a, $b) { return $a['default'] ? -1 : 1; });
        return $langList;
    }


    static public function getLangUrl($lang = false, $url = false)
    {

        // Get default lang
        if ($lang === false) {
            $lang = self::getDefaultLang();
        }

        // Parse url
        if ($url === false) {
            $url = $_SERVER['REQUEST_URI'];
        }
        $urlInfo = parse_url($url);

        $query = explode('&', $urlInfo['query']);
        foreach ($query as $key => $q) {
            if (preg_match('/lang=\w+/ui', $q)) {
                $query[$key] = 'lang=' . $lang;
            }
        }


        $newUrl = $urlInfo['path'] . ($query[0] ? '?' . implode("&", $query) : '?lang=' . $lang);


        return $newUrl;
    }


    static public function getChangeUrlLang($langTo, $url = false) {

        // Parse url
        if ($url === false) {
            $url = $_SERVER['REQUEST_URI'];
        }

        foreach (self::getLangShortList() as $lang) {
            if (preg_match("/^\/?{$lang}\//ui", $url) || preg_match("/^\/?{$lang}$/ui", $url)) {
                $url =  preg_replace("/^\/?{$lang}/ui", "/{$langTo}", $url);
            }
        }

        return $url;
    }


    static public function getDefaultLang($short = true)
    {
        $defaultLang = self::getLanguageList()[0];
        foreach (self::getLanguageList() as $lang) {
            if ($lang['default'] === true) {
                $defaultLang = $lang;
            }
        }

        return $short ? $defaultLang['name'] : $defaultLang;
    }


    static public function getLang($short = true)
    {

        $defaultLang = self::getLanguageListDefaultSort()[0];
        foreach (self::getLanguageList() as $lang) {
            if (!$_GET['lang'] && $lang['default'] === true) {
                $defaultLang = $lang;
            } else if ($_GET['lang'] === $lang['name']) {
                $defaultLang = $lang;
            }
        }

        return $short ? $defaultLang['name'] : $defaultLang;
    }

    static public function isDefault()
    {

        if (self::$_isDefault === null) {
            self::$_isDefault = (self::getDefaultLang() === self::getLang());
        }

        return self::$_isDefault;
    }

    static public function getCurrentLang() {
        return $_SESSION['lang'] ? $_SESSION['lang'] : self::getLang();
    }
}
