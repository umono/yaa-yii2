<?php

    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Headers:*');
    header('Access-Control-Allow-Methods:*');

    require __DIR__ . '/../vendor/autoload.php';

    require __DIR__ . '/../src/config/env.php';

    require __DIR__ . '/../src/config/msg.php';

    require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

    $config = require __DIR__ . '/../src/config/web.php';

    $application = new \yii\web\Application($config);

    $debugUrlRules = false;

    if ($debugUrlRules) {
        var_dump($application->getUrlManager()->rules);
        die;
    }

    $application->run();

