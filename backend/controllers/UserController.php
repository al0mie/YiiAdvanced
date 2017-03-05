<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\FormUpdate;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class SubscriptionController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['index', 'update'],
			'rules' => [
				[
					'allow' => true,
					'actions' => ['index', 'update'],
					'roles' => ['@'],
				],
			],
		];

		return $behaviors;
    }

	/**
     * @return array(User)|null
     */
	public function actionIndex()
	{
		$data = (new Query)->select(['users.id AS id', 'CONCAT_WS(" ", users.surname, users.name, users.middle_name) as full_name', 'users.login', 'DATE_FORMAT(FROM_UNIXTIME(user_subscription.end_date),  "%d-%m-%Y") as end_date'])
			->from('users')->leftJoin('user_subscription', 'user_subscription.user_id = users.id')
			->orderBy('id')->all();

		return $data;
	}

	/**
     * Finds the user model based on its primary key value.
	 *
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	protected function findModel($id)
	{
		if (($model = FormUpdate::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}