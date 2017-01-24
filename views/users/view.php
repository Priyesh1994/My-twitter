<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->userName;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h1><?= Html::encode($this->title) ?></h1>
                <?=$this->render('//microposts/_stats',[
                    'row_following' => $row_following,
                    'numberOfMicroposts' => $numberOfMicroposts,
                    'row_followed' => $row_followed])?>
            </div>
            <div class="col-lg-8">
                <p>
                    <?php if (!$followCheck) {?>
                        <?= Html::a('Follow', ['follow', 'followedId' => $model->userId], ['class' => 'btn btn-primary']) ?>
                    <?php  } else {?>
                        <?= Html::a('Unfollow', ['unfollow', 'followedId' => $model->userId], ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                </p>
                <?= $this->render('//microposts/_feed',['rows'=>$rows]);?>
            </div>
        </div>
    </div>

</div>
