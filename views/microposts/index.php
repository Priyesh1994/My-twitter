<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MicropostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-4">
        <h1><?php echo Yii::$app->user->identity->userName;?></h1>
        <?=$this->render('_stats',[
            'row_following' => $row_following,
            'numberOfMicroposts' => $numberOfMicroposts,
            'row_followed' => $row_followed])?>
        <?=$this->render('create',['model' => $model])?>
    </div>
    <div class="col-lg-8">
        <?=$this->render('_feed',['rows' => $rows])?>
    </div>
</div>
