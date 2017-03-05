<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\UserSubscription;

/**
 * Controller to clear out date subscribes
 */
class CleanController extends Controller
{
    /**
     * This command clear all out date subscribes
     */
    public function actionSubscribes()
    {
        if ($this->confirm('Do you want to delete all outdated subscribes?')) {
            $rowDeleted = UserSubscription::deleteAll('end_date < :current_date', [':current_date' => time()]);
            echo 'Removed ' . $rowDeleted . ' subscribes' . PHP_EOL;
        }
    }
}
