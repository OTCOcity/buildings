<?php
namespace frontend\controllers\backup;

use app\models\BOsCall;
use app\models\BOsFeedback;
use common\models\Thread;
use frontend\components\MiscFunc;
use frontend\models\File;
use frontend\models\forms\CallForm;
use frontend\models\forms\FeedbackForm;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Form controller
 */
class FormController extends Controller
{


    public function actionIndex($id)
    {

        $thread = Thread::findOne($id);
        $page = $thread->model;

        // Feedback form
        if ( Yii::$app->request->post('FeedbackForm') !== null) {

            $feedbackForm = $this->feedbackForm();

            if (!$feedbackForm->hasErrors()) {
                return $this->redirect('?fb-success');
            }
        }

        return $this->render('index.twig', [
            'page' => $page,
            'thread' => $thread,
            'fbs' => $page->fbs,
            'feedbackForm' => $feedbackForm,
        ]);


//        if (!Yii::$app->request->isAjax || !Yii::$app->request->isPost) throw new ForbiddenHttpException;


        // Call form
//        if ( Yii::$app->request->post('CallForm') !== null) {
//            return $this->callForm();
//        }


    }





    public function callForm() {


        $callForm = new CallForm();
        $callForm->load(Yii::$app->request->post());


        $os = new BOsCall();
        $os->thread_id = MiscFunc::getThreadInfo('form', 'id');
        $os->name = "Anonymous";
        $os->phone = $callForm->phone;
        $os->date = date("d.m.Y", time());
        $os->save(false);

        // Email to admin
        $emails = MiscFunc::getThreadData('options', 'email_personal');
        $emailsArr = [];
        foreach (explode(",", $emails) as $email) {
            $emailsArr[] = trim($email);
        }


        $subject = "Просьба связаться на сайте " . MiscFunc::getThreadData('options', 'sitename');
        Yii::$app->mailer->compose('toadmin/call.php', ['name' => $os->name, 'phone' => $os->phone, 'subject' => $subject])
            ->setFrom(Yii::$app->params['siteRobotEmail'])
            ->setTo($emailsArr)
            ->setSubject($subject)
            ->send();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'function' => "callSuccess",
        ];

    }



    public function feedbackForm() {

        $feedbackForm = new FeedbackForm();
        $feedbackForm->load(Yii::$app->request->post());

        if (!$feedbackForm->validate()) {

            return $feedbackForm;
        }


        // File upload
//        $feedbackForm->uploadFileInstance = UploadedFile::getInstance($feedbackForm, 'file');

//        $fileSrc = $feedbackForm->uploadFile();
//        $fileName = $feedbackForm->uploadFileInstance->name;


        $os = new BOsFeedback();
        $os->thread_id = MiscFunc::getThreadInfo('form', 'id');
        $os->name = $feedbackForm->name;
        $os->block_key = '';
//        $os->company = $feedbackForm->company;
        $os->phone = $feedbackForm->phone;
//        $os->city = $feedbackForm->city;
//        $os->email = $feedbackForm->email;
//        $os->theme = $feedbackForm->theme;
        $os->text = $feedbackForm->text;
        $os->visible = false;
//        $os->file = $fileSrc;
        $os->lang = Yii::$app->language;
        $os->date = time();
        $os->save(false);

        $os->source_id = $os->id;
        $os->save(false, ['source_id']);


        /*
        if ($fileName) { // Сохраняем в files rel

            $userFile = new File();
            $userFile->table = "b_os_feedback";
            $userFile->key = "file";
            $userFile->item_id = $os->id;
            $userFile->file = $fileSrc;
            $userFile->name = $fileName;
            $userFile->save(false);

        }
        */
        // Email to admin
        $emails = MiscFunc::getThreadData('options', 'email');
        $emailsArr = [];
        foreach (explode(",", $emails) as $email) {
            $emailsArr[] = trim($email);
        }


        // Email to admin
        $subject = "Отзыв на сайте " . MiscFunc::getThreadData('options', 'sitename');
        $mail = Yii::$app->mailer->compose('toadmin/feedback.php', ['form' => $os, 'subject' => $subject])
            ->setFrom(Yii::$app->params['siteRobotEmail'])
            ->setTo($emailsArr)
            ->setSubject($subject)
            ->send();


//        if ($fileName) {
//
//            $mail->attach(Yii::getAlias("@frontend/web/upload/orig/") . $fileSrc);
//        }


        return $feedbackForm;

    }

}
