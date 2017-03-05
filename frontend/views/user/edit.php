<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = 'Update User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['edit', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
            'name' => 'end_date',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
                'startDate' => date('d-m-Y'),
            ]
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
