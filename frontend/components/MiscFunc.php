<?php

namespace frontend\components;

use backend\eadmin\config\Config;
use backend\eadmin\config\Language;
use frontend\models\BCatalogGoods;
use frontend\models\FilterAge;
use frontend\models\FilterSize;
use Yii;
use yii\db\Query;

class MiscFunc
{
    static public $bodyClassname = "";
    static public $monthArr = ["", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];

    static private $threadInfo = [];
    static private $threadData = [];

    static private $nextNumbers = [];

    // Next number generator
    static public function nextNumber($key = 'nextNumber_key')
    {

        if (!isset(self::$nextNumbers[$key])) {
            self::$nextNumbers[$key] = 1;
        } else {
            self::$nextNumbers[$key]++;
        }
        return self::$nextNumbers[$key];
    }

    /**
     * Возвращает seoTitle либо name объекта
     * @param $obj
     * @return string
     */
    static public function generateBlockSeo($obj)
    {

        if ($obj->hasAttribute('seo_title') && $obj->seo_title) Yii::$app->params['seo_title'] = $obj->seo_title;
        if ($obj->hasAttribute('seo_keywords') && $obj->seo_keywords) Yii::$app->params['seo_keywords'] = $obj->seo_keywords;
        if ($obj->hasAttribute('seo_description') && $obj->seo_description) Yii::$app->params['seo_description'] = $obj->seo_description;
    }

    /**
     * Количество товаров в корзине
     * @return int
     */
    public function cartCount()
    {
        return count($_SESSION['cart']);
    }

    /**
     * Количество товаров в сравнении
     * @return int
     */
    public function compareCount()
    {
        return count($_SESSION['compare']);
    }


    /**
     * Получение информации о разделах из таблицы Thread(с кешированием)
     * @param $module - string / or $id - тип модуля или id раздела
     * @param $fld - string
     */
    static public function getThreadInfo($module, $fld = false)
    {

        if (!isset(self::$threadInfo[$module])) {

            if (is_numeric($module)) {

                self::$threadInfo[$module] = (new Query())->select('thread.*')->from('thread')->where(['id' => $module])->one();
            } else {

                self::$threadInfo[$module] = (new Query())->select('thread.*')->from('thread')->join('INNER JOIN', 'module', 'module.id = thread.module')->where(['module.controller' => $module])->one();
            }
        }


        if ($fld) {
            return self::$threadInfo[$module][$fld];
        } else {
            return self::$threadInfo[$module];
        }
    }

    /**
     * Получение информации о разделах из таблицы c_%module% (с кешированием)
     * @param $module - string
     * @param $fld - string
     */
    static public function getThreadData($module, $fld = false)
    {


        if (!isset(self::$threadData[$module])) {
            $moduleData = (new Query())->select('controller')->from('module')->where(['id' => self::getThreadInfo($module, 'module')])->one();
            self::$threadData[$module] = (new Query())->select('*')->from('c_' . $moduleData['controller'])->where(['lang' => 'ru', 'thread_id' => self::getThreadInfo($module, 'id')])->one();
        }

        if ($fld) {
            return self::$threadData[$module][$fld];
        } else {
            return self::$threadData[$module];
        }
    }


    /**
     * Склонение окончаний
     * @param $number - число
     * @param $after - массив ['комментарий','комментария','комментариев']
     * @return string
     */
    static public function pluralForm($number, $after = ['товар', 'товара', 'товаров'])
    {
        $cases = array(2, 0, 1, 1, 1, 2);

        return $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses morph(...)
     */
    static public function num2str($num)
    {


        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array( // Units
            array('копейка', 'копейки', 'копеек', 1),
            array('рубль', 'рубля', 'рублей', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else $out[] = $nul;
        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    static public function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }


    static public function smartStrToPrice($price)
    {

        $price = str_replace(",", ".", $price);
        $price = str_replace(" ", "", $price);
        preg_match_all("/\d+\.?\d+/ui", $price, $mathces);

        // $price = number_format((float)($mathces[0][0]), 0, ".", " ");

        return (float)$mathces[0][0];
        return $price;
    }

    static public function date($date) {

        $date = !is_numeric($date) ? strtotime($date) : $date;

        return date("d.m.Y", $date);
    }

    static public function dateTime($date) {


        $date = !is_numeric($date) ? strtotime($date) : $date;

        return date("d.m.Y - H:i:s", $date);
    }


    /*
    static public function updateGroupSize($good, $type) {

        $threadId = (int)$good->attributes['thread_id'];

        // РАЗМЕРЫ

        // Список из конфига
        $sizeConfig = Config::getConfig('catalog_goods', true, 'size');
        $sizeData = $sizeConfig['data']['values'];

        // Ищем все размеры товаров в этой группе
        $sizeArr = [];
        $sizeArrValues = [];

        $sql = "SELECT `value` FROM `relations` where `key` = 'size'  AND `item_id` in (SELECT `id` FROM `b_catalog_goods` WHERE `thread_id` = {$threadId})";
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        foreach ($result as $val) {
            $sizeVal = $sizeData[$val['value']];
            if (!empty(trim($sizeVal))) {
                $sizeArr[md5($sizeVal)] = $sizeVal;
                $sizeArrValues[md5($sizeVal)] = $val['value'];
            }

        }

        // Удаляем / оставляем то что есть / нет в массиве
        foreach (FilterSize::find()->where(['thread_id' => $threadId])->all() as $fs) {
            if (in_array($fs->size, $sizeArr)) {
                unset($sizeArr[md5($fs->size)]);
            } else {
                FilterSize::deleteAll(['thread_id' => $threadId, 'size' => $fs->size]);
            }
        }

        // Добавляем новые
        foreach ($sizeArr as $key => $size) {
            $newFS = new FilterSize();
            $newFS->thread_id = $threadId;
            $newFS->size = $size;
            $newFS->sort = $sizeArrValues[$key];
            $newFS->save(false);
        }


        // ВОЗРАСТ

        // Список из конфига
        $ageConfig = Config::getConfig('catalog_goods', true, 'age');
        $ageData = $ageConfig['data']['values'];


        // Ищем все размеры товаров в этой группе
        $ageArr = [];
        $ageArrValues = [];

        $sql = "SELECT `value` FROM `relations` where `key` = 'age'  AND `item_id` in (SELECT `id` FROM `b_catalog_goods` WHERE `thread_id` = {$threadId})";
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        foreach ($result as $val) {
            $ageVal = $ageData[$val['value']];
            if (!empty(trim($ageVal))) {
                $ageArr[md5($ageVal)] = $ageVal;
                $ageArrValues[md5($ageVal)] = $val['value'];
            }

        }

        // Удаляем / оставляем то что есть / нет в массиве
        foreach (FilterAge::find()->where(['thread_id' => $threadId])->all() as $fs) {
            if (in_array($fs->age, $ageArr)) {
                unset($ageArr[md5($fs->age)]);
            } else {
                FilterAge::deleteAll(['thread_id' => $threadId, 'age' => $fs->age]);
            }
        }

        // Добавляем новые
        foreach ($ageArr as $key => $age) {
            $newFA = new FilterAge();
            $newFA->thread_id = $threadId;
            $newFA->age = $age;
            $newFA->sort = $ageArrValues[$key];
            $newFA->save(false);
        }




    }
    */

    // Language block

    /** Transalte message
     * @param string $category
     * @param string $message
     * @return string
     */
    static public function t($category, $message)
    {
        return Yii::t($category, $message);
    }

    /** Add Lang prefix to url
     * @param string $category
     * @param string $message
     * @return string
     */
    static public function urlLang($url = false, $lang = false)
    {

        // Url
        $url = $url ? $url : $_SERVER['REQUEST_URI'];
//        var_dump(self::urlLangPregMasks());
        $url = preg_replace(self::urlLangPregMasks(), '', $url);
        $url = trim($url, '/');
//        var_dump($url);

        // Language
        $language = $lang ? $lang : Yii::$app->language;

        $result = '/' . $language . '/' . $url;

        return $result;
    }

    static public $_urlLangPregMasks;

    static public function urlLangPregMasks()
    {

        if (!self::$_urlLangPregMasks) {
            self::$_urlLangPregMasks = [];
            foreach (Language::getLangShortList() as $lang) {
                self::$_urlLangPregMasks[] = "/^\/?{$lang}(\/|$)/ui";
            }
        }
        return self::$_urlLangPregMasks;
    }


    /**
     * @return string
     */
    public static function youtubeVideoId($url)
    {
        if (preg_match_all("/\?v=([^&]+)/", $url, $matches)) {
            $result = $matches[1][0];
        } elseif (preg_match_all("/embed/([^?]+)/", $url, $matches)) {
            $result = $matches[1][0];
        }
        return $result;
    }


    public static function microUniqueId()
    {
        return microtime(true) . '_' . uniqid();
    }

    static public function priceFormat($price)
    { // 9 480
        $price = (float)$price;
        return is_numeric($price) ? number_format($price, 0, " ", " ") : $price;
    }

    static public function priceFormat2($price)
    { // 9 480,00
        $price = (float)$price;
        return is_numeric($price) ? number_format($price, 2, ",", " ") : $price;
    }

    function slugify($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public static function queryToArray($qry)
    {
        $result = array();
        //string must contain at least one = and cannot be in first position
        if(strpos($qry,'=')) {

            if(strpos($qry,'?')!==false) {
                $q = parse_url($qry);
                $qry = $q['query'];
            }
        }else {
            return false;
        }

        foreach (explode('&', $qry) as $couple) {
            list ($key, $val) = explode('=', $couple);
            $result[$key] = $val;
        }

        return empty($result) ? false : $result;
    }

    public static function queryGet($key) {
        if (Yii::$app->params['seo_filter_query'][$key]) {
            return Yii::$app->params['seo_filter_query'][$key];
        } else {
            return Yii::$app->request->get($key);
        }
    }

    public static function trimPhone($phone, $len = 10) {
        return substr(preg_replace("/\D/ui", '', $phone), -$len);

    }


    public static function beautyPhone($phone) {
        $phone = preg_replace('/\D/ui', '', $phone);
        $phone = mb_substr($phone, -10, null, 'utf-8');

        if (mb_strlen($phone, 'utf-8') !== 10) {
            return $phone;
        }

        return '+7 (' . mb_substr($phone, 0, 3, 'utf-8')
            . ') ' . mb_substr($phone, 3, 3, 'utf-8')
            . '-' . mb_substr($phone, 6, 2, 'utf-8')
            . '-' . mb_substr($phone, 8, 2, 'utf-8');
    }

    public static function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    static public function getCookie($key) {
        return $_COOKIE[$key];
    }
}