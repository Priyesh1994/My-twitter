<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userName')->textInput(['maxlength' => true])->label('Name') ?>

    <?= $form->field($model, 'userEmail')->textInput(['maxlength' => true])->label('Email') ?>

    <?= $form->field($model, 'userPass')->passwordInput(['maxlength' => true])->label('Password') ?>

    <?= $form->field($model, 'confPass')->passwordInput(['maxlength' => true])->label('Confirm Password') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
