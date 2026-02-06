<?php

namespace common\models;

/**
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceMessage $sourceMessage
 */
class Message extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    public function getSourceMessage() {

        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }


}
