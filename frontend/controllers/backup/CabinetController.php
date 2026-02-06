<?php
namespace frontend\controllers\backup;

use frontend\models\BOrder;
use frontend\models\BOrderItem;
use Yii;
use frontend\components\Misc;
use frontend\models\BClients;
use frontend\models\cabinetForms\PasswordForm;
use frontend\models\cabinetForms\ProfileForm;
use frontend\models\cabinetForms\RekForm;
use frontend\models\File;
use frontend\models\LoginForm;
use frontend\models\PasswordFogForm;
use frontend\models\RegForm;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * Site controller
 */
class CabinetController extends Controller
{

    public function actionIndex($id)
    {


        // Авторизация / Регистрация ajax
        if (Yii::$app->request->isAjax) {

            // Авторизация
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->login();
                    return "loginSuccess";
                } else {
                    Yii::$app->response->format = "json";
                    return ActiveForm::validate($model);
                }
            }

            // Регистрация
            $model = new RegForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->registrate();
                    return "regSuccess";
                } else {
                    Yii::$app->response->format = "json";
                    return ActiveForm::validate($model);
                }
            }

            // Забыли пароль
            $model = new PasswordFogForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->newPassword();
                    return "passSuccess";
                } else {
                    Yii::$app->response->format = "json";
                    return ActiveForm::validate($model);
                }
            }

        }

        // Редирект на авторизацию
        if (Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->user->loginUrl[0]);
            Yii::$app->end();
        }


        // Загрузка договора
        if (Yii::$app->request->isPost) {

            $file = UploadedFile::getInstanceByName('dogovor');

            if ($file) {

                if ($file->size > 12328960) {
                    Yii::$app->session->setFlash('cabinet-dogovor-error', 'Размер не должен превышать 10Мб');
                    $this->refresh();
                    Yii::$app->end();
                }
                if (!in_array($file->extension, ['doc', 'docx'])) {
                    Yii::$app->session->setFlash('cabinet-dogovor-error', 'Договор должен быть в формате Word');
                    $this->refresh();
                    Yii::$app->end();
                }

                $directory = Yii::getAlias('@frontend/web/upload/orig/');
                $uid = uniqid(time(), true);
                $fileName = $uid . '.' . $file->extension;
                $filePath = $directory . $fileName;
                if ($file->saveAs($filePath)) {

                    $user = BClients::findOne(Yii::$app->user->id);
                    $user->dogovor = 0;
                    $user->file_dog = $fileName;
                    $user->save(false);

                    File::deleteAll(['table' => "b_clients", 'key' => "file_dog", 'item_id' => $user->id]);

                    $userFile = new File();
                    $userFile->table = "b_clients";
                    $userFile->key = "file_dog";
                    $userFile->item_id = $user->id;
                    $userFile->file = $fileName;
                    $userFile->name = $file->name;
                    $userFile->save(false);


                    // Email to admin
                    $subject = "Новый договор на " . Yii::$app->params['sitename'];
                    Yii::$app->mailer->compose('toadmin/new_dog.php', ['user' => $user, 'subject' => $subject])
                        ->setFrom(Yii::$app->params['siteRobotEmail'])
                        ->setTo(Yii::$app->params['adminEmail'])
                        ->setSubject($subject)
                        ->send();


                    $this->refresh();
                    Yii::$app->end();
                }



            }
        }

//        $thread = Thread::findOne($id);
//        $page = $thread->model;


        Misc::$bodyClassname = "person bgNum1";


        return $this->actionProfile();



    }


    /**
     * @param $id
     * @param $params
     * @throws HttpException
     * @return false
     */
    public function actionView($id, $params)
    {
        Misc::$bodyClassname = "person bgNum1";


        $paramsArr = explode("/", $params);

        // Logout
        if ($paramsArr[0] == 'logout') {
            $this->actionLogout();
            return true;
        }

        // Activate client
        if ($paramsArr[0] == 'activate') {
            $this->actionActivate($paramsArr);
            return true;
        }

        // Soc login
        if ($paramsArr[0] == 'soclogin') {
            return $this->actionSoclogin($paramsArr);
        }

        // Activate success
        if ($paramsArr[0] == 'activatesuccess') {
            return $this->actionActivatesuccess($paramsArr);
        }

        // Password change action
        if ($paramsArr[0] == 'password') {
            return $this->actionPassword($paramsArr);
        }

        // Rek change action
        if ($paramsArr[0] == 'rek') {
            return $this->actionRek($paramsArr);
        }

        // Rek change action
        if ($paramsArr[0] == 'history') {
            return $this->actionHistory($paramsArr);
        }


        throw new ForbiddenHttpException();

        return false;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout(false);

        $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Активация аккаунта
     */
    public function actionActivate($paramsArr)
    {

        $id = (int)$paramsArr[1];
        $token = $paramsArr[2];

        $user = BClients::find()->where(['id' => $id, 'token' => $token])->one();

        if ($user === null) {
            throw new ForbiddenHttpException();

        } else {

            $user->active = 1;
            $user->token = "";
            $user->save(false);

            Yii::$app->user->login($user);

            $this->redirect('/cabinet/activatesuccess');
        }


    }


    /**
     * Вывод сообщения об успешной активации
     */
    public function actionActivatesuccess()
    {

        Misc::$bodyClassname = "person bgNum1";

        return $this->render('activate_success.twig', []);

    }


    /**
     * Активация аккаунта
     */
    public function actionSocLogin($paramsArr)
    {


        $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $data = json_decode($s, true);


        if (!$data['email']) { // Не получена почта

            $this->redirect('/#soc-auth-error');

        } else if ($client = BClients::findByEmail($data['email'])) { // Есть такой клиент

            Yii::$app->user->login($client);
            $this->redirect(Yii::$app->request->referrer);

        } else {  // Нет такого клиент

            $client = new BClients();
            $client->active = 1;
            $client->email = $data['email'];
            $client->name = $data['first_name'];
            $client->sirname = $data['last_name'];

            $client->save(false);
            $this->redirect('/cabinet');

            Yii::$app->user->login($client);
            $this->redirect('/cabinet');
        }

        //$data['email'] - соц. сеть, через которую авторизовался пользователь
        //$data['network'] - соц. сеть, через которую авторизовался пользователь
        //$data['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
        //$data['first_name'] - имя пользователя
        //$data['last_name'] - фамилия пользователя

    }




    public function actionProfile()
    {

        $profileForm = new ProfileForm();

        if (Yii::$app->request->isPost && $profileForm->load(Yii::$app->request->post())) {

            $user = BClients::findOne(Yii::$app->user->id);
            $user->setAttributes($profileForm->getAttributes(), false);
            $user->save(false);

            $this->refresh();
        }

        $profileForm->setAttributes(Yii::$app->user->identity->getAttributes(), false);

        return $this->render('profile.twig', ['profileForm' => $profileForm, 'user' => Yii::$app->user->identity]);


    }

    public function actionPassword()
    {
        $passwordForm = new PasswordForm();

        if (Yii::$app->request->isPost && $passwordForm->load(Yii::$app->request->post()) && $passwordForm->validate()) {

            $user = BClients::findOne(Yii::$app->user->id);
            $user->password = Yii::$app->security->generatePasswordHash($passwordForm->newPassword);
            $user->save(false);

            Yii::$app->session->setFlash('passwordChange', "passwordChange");

            $this->refresh();

        }

        return $this->render('password.twig', ['passwordForm' => $passwordForm, 'user' => Yii::$app->user->identity]);


    }

    public function actionRek()
    {

        // Если не Юр.лицо - Forbiden
        if (!Yii::$app->user->identity->type) throw new ForbiddenHttpException();

        $rekForm = new RekForm();

        if (Yii::$app->request->isPost && $rekForm->load(Yii::$app->request->post()) && $rekForm->validate()) {


            $user = BClients::findOne(Yii::$app->user->id);
            $user->setAttributes($rekForm->getAttributes(), false);
            $user->save(false);

            $this->refresh();

        }

        $rekForm->setAttributes(Yii::$app->user->identity->getAttributes(), false);

        return $this->render('rek.twig', ['rekForm' => $rekForm, 'user' => Yii::$app->user->identity]);


    }


    public function actionHistory($paramsArr) {

        if ((int)$paramsArr[1]) {

            return $this->actionHistoryView((int)$paramsArr[1]);

        }

        $orders = BOrder::find()->where(['block_id' => Yii::$app->user->id, 'block_key' => 'clients'])->all();

        return $this->render('history.twig', ['orders' => $orders, 'user' => Yii::$app->user->identity]);
    }

    public function actionHistoryView($id) {


        $order = BOrder::findOne($id);



        return $this->render('history_view.twig', ['order' => $order]);
    }

}