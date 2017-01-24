<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MicropostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "Micropost Feed";
?>
<div class="microposts-index">

    <ol class="microposts">
    <h3><?= Html::encode($this->title) ?></h3>
    <?php
        foreach ($rows as $row) {
    ?>
            <li>
                <div class="microContent">
                    <div class="user"><h4 style="margin: 3px"><?php echo $row['userName']?></h4></div>
                    <div class="content"><?php echo $row['content']?></div>
                </div>
            </li>
    <?php } ?>
    </ol>
</div>
