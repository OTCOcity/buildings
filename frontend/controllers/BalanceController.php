<?php
namespace frontend\controllers;

use frontend\models\Building;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * About controller
 */
class BalanceController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    throw new ForbiddenHttpException();
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $buildings = Building::find()
            ->where(['visible' => 1])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        $income = 0;
        $expense = 0;

        foreach ($buildings as $building) {
            $rentCost = $this->normalizeAmount($building->rent_cost ?? 0);
            $paymentAmount = $this->normalizeAmount($building->payment_amount ?? 0);

            $building->rentCostValue = $rentCost;
            $building->paymentAmountValue = $paymentAmount;
            $building->netValue = $rentCost - $paymentAmount;
            $building->netBadge = $building->netValue >= 0 ? 'Плюс' : 'Минус';
            $building->netClass = $building->netValue >= 0 ? 'money__net--pos' : 'money__net--neg';
            $building->badgeClass = $building->netValue >= 0 ? 'badge--pos' : 'badge--neg';

            $income += $rentCost;
            $expense += $paymentAmount;
        }

        $netTotal = $income - $expense;

        return $this->render('index.twig', [
            'buildings' => $buildings,
            'income' => $income,
            'expense' => $expense,
            'netTotal' => $netTotal,
            'kpiHint' => $netTotal > 0
                ? 'Портфель в плюсе'
                : ($netTotal < 0 ? 'Портфель в минусе' : 'Портфель в нуле'),
        ]);
    }

    private function normalizeAmount($value)
    {
        if (is_numeric($value)) {
            return (int)$value;
        }

        $normalized = preg_replace('/[^\d\-]/u', '', (string)$value);

        if ($normalized === '' || $normalized === '-') {
            return 0;
        }

        return (int)$normalized;
    }

}
