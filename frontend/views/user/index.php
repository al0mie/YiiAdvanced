<?php

use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'login',
            'fullName',
            'email',
            [
                'label' => 'end_date',
                'attribute' => 'end_date',
                'filter' => DatePicker::widget([
                    'name' => 'end_date',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy'
                    ]
                ]),

                'format' => ['date', 'php:d-m-Y'],
                'value' => function($model) {
                    $subscription = $model->user_subscription;
                    return $subscription ? $subscription->end_date : null;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ]
    ]); ?>
</div>
