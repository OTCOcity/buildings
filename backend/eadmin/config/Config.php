<?php
namespace backend\eadmin\config;

use Yii;

/**
 * Config Class
 */
class Config
{

    /**
     * @param $controller - название котнроллера
     * @param bool $block - блок или каталог
     * @param bool $key   - если нужно вернуть только конфиг определенного поля
     * @return Config array
     */
    static public function getConfig($controller, $block = false, $key = false)
    {

        $folder = !$block ? Yii::getAlias('@backend/eadmin/config/cats/') : Yii::getAlias('@backend/eadmin/config/blocks/');
        $file = $folder.$controller.".php";
        if (is_file($file)) {

            $config = require $file;
        } else {

            $config = null;
        }

        // Если указано поле возвращаем его конфиг
        if ($key) {
            if (is_array($config['tabs']))
            foreach ($config['tabs'] as $tab) {
                if (is_array($tab['fields']))
                foreach ($tab['fields'] as $field) {
                    if ($field['key'] == $key) {
                        $config = $field;
                        return $config;
                    }
                }
            }
        }
        return $config;

    }


}
