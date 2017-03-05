<?php

namespace frontend\controllers;

use common\models\FormUpdate;
use Yii;
use frontend\models\SubscriptionSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * User controller
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex()
    {
        $filterModel = new SubscriptionSearch();
        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Update user model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {

            if ($model->user_subscription !== null) {
                $model->end_date = date('d-m-Y', $model->user_subscription->end_date);
            }

            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = FormUpdate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
