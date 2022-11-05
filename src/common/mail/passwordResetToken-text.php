<?php

/* @var $this yii\web\View */
/* @var $user \yii\db\ActiveRecord */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => '1312']);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
