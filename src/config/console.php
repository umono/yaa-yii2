<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/6
     * Time: 7:28 PM
     */

    $common = require(__DIR__ . '/common.php');
    unset($common['components']['log']);

    $config = [
        'id' => $_ENV['APP_ID'] . '-console',

        'controllerNamespace' => 'app\common\commands\controllers',

        'controllerMap' => [
            'fixture' => [
                'class' => 'yii\faker\FixtureController',
            ],
        ],
        'components'    => [
            'urlManager' => [
                'baseUrl' => $_ENV['APP_URL'],
            ],
        ],
    ];

    return \yii\helpers\ArrayHelper::merge($common, $config);
