<?php

namespace frontend\controllers\backup;

use frontend\components\FileHelper;
use frontend\components\MiscData;
use frontend\components\MiscFunc;
use frontend\models\crm\Client;
use frontend\models\crm\ClientRequests;
use frontend\models\crm\CrmUser;
use frontend\models\forms\LoginForm;
use frontend\models\forms\OfferForm;
use frontend\models\forms\RegForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Lk controller
 */
class LkController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'regsuccess'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'logout', 'offer'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Список видео
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $client = Client::findOne(Yii::$app->user->id);

        // Согласился или нет с Договорм оферты
        if ($client->offer_accept) {

            return $this->render('index.twig', [
                'client' => $client
            ]);

        } else {

            $offerForm = new OfferForm();

            if (Yii::$app->request->isPost && $offerForm->load(Yii::$app->request->post()) && $offerForm->validate()) {

                $client->offer_accept = $offerForm->accept;
                $client->save(false);

                return $this->refresh();

            }

            return $this->render('offer.twig', [
                'client' => $client,
                'offerForm' => $offerForm
            ]);

        }

    }

    public function actionLogin($params)
    {

        if (!Yii::$app->user->isGuest) return $this->redirect('/lk');

        $loginForm = new LoginForm();

        if (Yii::$app->request->isPost && $loginForm->load(Yii::$app->request->post())) {

            $loginForm->validatePassword('password', false);

            if (!$loginForm->hasErrors()) {
                $loginForm->login();
                return $this->redirect('/lk');
            }
        }

        $regForm = new RegForm();

        if (Yii::$app->request->isPost && $regForm->load(Yii::$app->request->post())) {


            if ($regForm->validate()) {
                if (!$regForm->hasErrors()) {

                    $client = $regForm->registration();
                    return $this->redirect('/lk/regsuccess?token=' . $client->auth_key);
                }
            }
        }

        return $this->render('login.twig', [
            'loginForm' => $loginForm,
            'regForm' => $regForm,
            'objectRoomTypes' => (new ClientRequests())->roomTypes,
            'objectRentTypes' => (new ClientRequests())->rentTypes,
        ]);
    }

    public function actionLogout($params)
    {
        Yii::$app->user->logout();
        return $this->goBack();
    }


    public function actionRegsuccess($token) {

        $client = Client::findOne(['auth_key' => $token]);

        if ($client === null) throw new NotFoundHttpException();

        return $this->render('reg_success.twig', [
            'client' => $client
        ]);
    }

    public function actionOffer() {


        /** @var Client $client */
        $client = Yii::$app->user->identity;

        // Options
        $options = MiscData::getDbData('c_options');

        // Manager
        $manager = $client->managerModel;

        // Client request
        $request = $client->getSiteActiveRequests()->one();
        if ($request === null) {
            $request = $client->getRequests()->one();
        }


        $offerDoc = $options[0]['offer_doc'];
        $filePath = Yii::getAlias('@frontend/web/upload/orig/' . $offerDoc);

        if (!is_file($filePath)) {
            throw new NotFoundHttpException();
        }

        FileHelper::downloadFile("Договор оферты {$client->name}.docx", FileHelper::templateDocx(
            $filePath,
            [
                'site_url' => Yii::$app->params['siteurl'],
                'company_name' => $options[0]['sitename'],
                'company_manager' => $manager->fullName,
                'company_phone' => $manager->phone,
                'company_email' => $options[0]['email'],
                'user_name' => $client->name,
                'user_phone' => $client->phone,
                'user_object_type' => ($request !== null && $request->roomAndRentType) ? $request->city->name . ', ' . $request->roomAndRentType : 'Не указано',
                'user_city' => $client->adres,
            ]
        ));


        return 123;
    }


    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            Client::updateAll(['sync_count' => time(), 'ip' => MiscFunc::getIp()], ['id' => Yii::$app->user->identity->id]);
        }

        return parent::beforeAction($action);
    }

}
