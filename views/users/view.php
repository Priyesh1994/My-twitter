<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->userName;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$followCheck = (new \yii\db\Query())
    ->from('relationships')
    ->where(['and','follower_id=:followerId','followed_id=:followedId'])
    ->addParams([':followerId'=>Yii::$app->user->getId(),':followedId'=>$model->userId])
    ->count();
?>
<div class="users-view">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h1><?= Html::encode($this->title) ?></h1>
                <?=$this->render('//microposts/_stats',['id' => $model->userId])?>
            </div>
            <div class="col-lg-8">
                <p>
                    <?php if (!$followCheck) {?>
                        <?= Html::a('Follow', ['follow', 'followedId' => $model->userId], ['class' => 'btn btn-primary']) ?>
                    <?php  } else {?>
                        <?= Html::a('Unfollow', ['unfollow', 'followedId' => $model->userId], ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                </p>
                <?= $this->render('//microposts/_feed',['profileId'=>$model->userId]);?>
            </div>
        </div>
    </div>

</div>
