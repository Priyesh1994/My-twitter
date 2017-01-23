<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Microposts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="microposts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['tid'=>'textfield','rows' => 6,'placeholder' => "Create your micropost..."])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Create',['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $("#microposts-content").text("");
</script>
