<?php
namespace backend\components\classes;


use common\models\User;
use common\models\UserAccess;
use Yii;
use common\models\Thread;
use yii\base\Component;

class Arules extends Component
{

    public function getIsSuper() {

        return Yii::$app->user->identity->status === 0;
    }

    public function getIsAdmin() {

        return Yii::$app->user->identity->status === 1;
    }

    public function getIsEditor() {

        return Yii::$app->user->identity->status === 2;
    }

    public function getIsEditorById($id) {

        return User::findOne($id)->status === 2;
    }


    public function getCanEditThread($threadId) {


        $module = Thread::findOne($threadId)->moduleinfo;

        return $module->edit || Yii::$app->arules->isSuper;

    }

    public function getCanDeleteThread($threadId) {

        $module = Thread::findOne($threadId)->moduleinfo;

        return $module->delete || Yii::$app->arules->isSuper;
    }

    public function getCanCreateThread($threadId) {

        $module = Thread::findOne($threadId)->moduleinfo;

        return $module->create || Yii::$app->arules->isSuper;
    }

    public function getCanSysThread($threadId) {


        return self::getCanDeleteThread($threadId) || self::getCanEditThread($threadId);
    }


    /**
     * Проверка прав пользователя
     * @param $userId
     * @param $threadId
     * @param $blockKey
     * @param $action
     * @return bool
     */
    public function checkUserRule($userId, $threadId, $blockKey, $action) {

        if (!Yii::$app->arules->getIsEditorById($userId)) return true; // Для всех кроме едитора возвращаем true

        $uaCount = UserAccess::find()->where(['user_id' => $userId, 'thread_id' => $threadId, 'block_key' => $blockKey, 'action' => $action])->count();
        return (boolean)$uaCount;

    }


}