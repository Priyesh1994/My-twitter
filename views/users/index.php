<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\uersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$checkAdmin = (new \yii\db\Query())
    ->select(['admin'])
    ->from('users')
    ->where(['userId' => Yii::$app->user->identity->getId()])
    ->all();
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'userName:text:Name',
            ['class' => 'yii\grid\ActionColumn',
             'header' => 'Action',
             'template' => '{view} {delete}',
             'buttons' => [
                     'delete' => $checkAdmin[0]['admin'] ? (function($url,$model,$checkAdmin){
                         return Html::a(
                             '<span class="glyphicon glyphicon-trash">',['delete','id'=>$model->userId],['onClick'=>"javascript: return confirm('Please confirm deletion..');"]);
                     }):(function($model) {
                         return;
                     })
                ]
            ],
        ],
    ]); ?>
</div>
