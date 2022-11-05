<?php
/**
 * Created by PhpStorm.
 * User: umono
 * Date: 2019/3/20
 * Time: 12:47 PM
 */
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= '出现错误 - 管理后台 - ' . Yii::$app->name; ?></title>
    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            margin-top: 48px;
            max-width: 616px;
            padding: 0 16px;
            font-family: 'Roboto', 'Helvetica Neue', sans-serif;
            font-size: 16px;
            line-height: 24px;
            color: rgba(0,0,0,0.87);
        }
        h1, h2, h3 {
            font-family: 'Roboto', 'Helvetica Neue', sans-serif;
            font-weight: 300;
        }
        @media screen and (max-width: 616px) {
            body {
                margin-top: 24px;
            }

            .logo  {
                margin: 0;
            }
        }
    </style>
</head>
<body>
<h1><?= $exception->getMessage(); ?></h1>
<a class="logo">
    <!--<img src="/logo.jpeg" alt="">-->
</a>

</body>
</html>
