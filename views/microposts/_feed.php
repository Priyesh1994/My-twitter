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
    if ($profileId==0) {
        $userId = Yii::$app->user->identity->getId();
        $ids = (new \yii\db\Query())
            ->select(['followed_id'])
            ->from('relationships')
            ->where(['follower_id' => $userId]);

        $rows = (new \yii\db\Query())
            ->select(['userName', 'content'])
            ->from('users')
            ->join('INNER JOIN', 'microposts', 'users.userId = microposts.userId')
            ->where(['or', 'users.userId=:userId', ['users.userId' => $ids]])
            ->addParams([':userId' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }
    else
    {
        $rows = (new \yii\db\Query())
            ->select(['userName', 'content'])
            ->from('users')
            ->join('INNER JOIN', 'microposts', 'users.userId = microposts.userId')
            ->where('users.userId=:profileId')
            ->addParams([':profileId' => $profileId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }
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
