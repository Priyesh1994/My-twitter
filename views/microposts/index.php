<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MicropostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//ProfileId declared for use in _feed.php
/** @var INTEGER $profileId */
$profileId=0;
?>
<div class="row">
    <div class="col-md-4">
        <h1><?php echo Yii::$app->user->identity->userName;?></h1>
        <?=$this->render('_stats',['id' => Yii::$app->user->getId()])?>
        <?=$this->render('create',['model' => $model])?>
    </div>
    <div class="col-lg-8">
        <?=$this->render('_feed',['profileId'=>$profileId])?>
    </div>
</div>
