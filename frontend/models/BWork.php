<?php

namespace frontend\models;

use common\models\Thread;

/**
 * This is the model class for table "b_works".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $block_id
 * @property string $block_key
 * @property string $name
 * @property string $link
 * @property string $image
 * @property string $visible
 * @property integer $sort
 *
 * @property string $url
 * @property Thread $thread
 * @property array $contentItems
 */
class BWork extends \yii\db\ActiveRecord
{

    public $_thread;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    }

    public function getThread()
    {

        if (!$this->_thread->id) {
            $this->_thread = Thread::findOne($this->thread_id);
        }

        return $this->_thread;
    }

    public function getUrl()
    {

        return $this->thread->url . "/" . $this->link;
    }

    public function getNextProject()
    {

        $work = BWork::find()->where(['>', 'sort', $this->sort])->orderBy(['sort' => SORT_ASC])->andWhere(['visible' => 1])->one();
        if ($work === null) {
            $work = BWork::find()->where(['>', 'id', $this->id])->andWhere(['visible' => 1])
                ->orderBy(['id' => SORT_ASC])->one();
        }
        if ($work === null) {
            $work = BWork::find()->where(['<>', 'id', $this->id])->andWhere(['visible' => 1])
                ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->one();
        }
        return $work;
    }

    public function getContentItems()
    {
        return $this->hasMany(BWorkBlock::className(), ['block_id' => 'id'])
            ->andWhere(['lang' => 'ru', 'visible' => 1])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getTeam() {
        $team = [];
        foreach (explode(PHP_EOL, $this->t_team) as $row) {
            $pn = explode(',', $row);
            if (!trim($pn[0])) continue;
            $team[] = [trim($pn[0]), trim($pn[1])];
        }
        return $team;
    }


}
