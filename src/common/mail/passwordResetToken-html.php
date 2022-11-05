<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \yii\db\ActiveRecord */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => '1231']);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
