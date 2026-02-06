<?php

namespace common\models;

use backend\eadmin\config\Config;
use Yii;
use yii\base\Object;
use yii\db\Query;
use yii\web\HttpException;

/**
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message $messageModel
 *
 */
class SourceMessage extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    public function getMessageModel() {

        return $this->hasOne(Message::className(), ['id' => 'id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $message = $this->messageModel;
            if ($message !== null) $message->delete();
            return true;
        }
        return false;
    }

    static public function findByLang($category, $message, $language) {

        return SourceMessage::find()
            ->leftJoin('message', 'message.id = source_message.id')
            ->where([
                'source_message.category' => $category,
                'source_message.message' => $message,
                'message.language' => $language
            ])
            ->one();

    }

}
