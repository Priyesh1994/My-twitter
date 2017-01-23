<?php

/* @var $this yii\web\View */

$this->title = 'My Twiiter Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to the MiniTwitter App</h1>
        <p>As the name suggest, it is the miniature version of immensely popular Twitter app, developed as a part of Project.</p>
        <a role="button" class="btn btn-primary btn-lg" href="<?php echo \yii\helpers\Url::toRoute(['users/create']) ?>" >Sign Up now!</a>
    </div>
</div>
