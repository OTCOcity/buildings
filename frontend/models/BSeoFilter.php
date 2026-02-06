<?php

namespace frontend\models;

/**
 *
 * @property integer $id
 * @property integer $source_id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $main_image
 * @property string $name
 * @property string $url_from
 * @property string $url_to
 * @property string $description
 * @property string $keywords
 * @property string $text
 */
class BSeoFilter extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_seo_filter';
    }



}
