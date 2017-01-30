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
        <?php
        $name = Yii::$app->user->identity->userName;
        echo
        Html::a('Create','ajax-index', [
            'class' => "btn btn-success",
            'onclick'=>"$.ajax({
            type     :'POST',
            cache    : false,
            url  : 'ajax-index',
            data : 
            {
                'content' : $('#microposts-content').val()
            },
            success  : function(response) {
               var ht1 = \"<li><div class='microContent'><div class='user'><h4>\";
               var name = \"$name\";
               var ht2 = \"</h4><div><div class='content'>\";
               var lt = \"</div></div></li>\";
               var resp = response;
               $('.microposts h3').after(ht1+name+ht2+resp+lt);
            }
            });return false;",
            ]);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $("#microposts-content").text("");
</script>
