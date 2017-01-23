<?php
/**
 * Created by PhpStorm.
 * User: PRIYESH
 * Date: 23-01-2017
 * Time: 02:22
 */
$microposts = (new \yii\db\Query())
    ->from('microposts')
    ->where('userId=:userId')
    ->addParams([':userId'=>$id])
    ->count();
$row_following = (new \yii\db\Query())
    ->from('relationships')
    ->where('follower_id=:followerId')
    ->addParams([':followerId'=>Yii::$app->user->getId()])
    ->count();
$row_followed = (new \yii\db\Query())
    ->from('relationships')
    ->where('followed_id=:followedId')
    ->addParams([':followedId'=>$id])
    ->count();
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php echo $microposts?> Microposts <br/>
    <?php echo $row_following?> Following |
    <?php echo $row_followed?> Followers
</body>
</html>