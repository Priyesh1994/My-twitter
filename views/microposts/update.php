<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Microposts */

$this->title = 'Update Microposts: ' . $model->Id;
$this->params['breadcrumbs'][] = ['label' => 'Microposts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Id, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="microposts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
