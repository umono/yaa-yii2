<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/5
     * Time: 6:04 PM
     */


    $common = require(__DIR__ . '/common.php');
    $config = [
        'id' => $_ENV['APP_ID'] . '-web',

        'aliases' => [
            '@bower' => '@vendor/bower-asset',
            '@npm'   => '@vendor/npm-asset',
        ],

        'components' => [
            'request' => [
                'class'               => \umono\multiple\service\RequestService::class,
                'cookieValidationKey' => $_ENV['APP_COOKIE_VALIDATION_KEY'],
            ],
        ],
    ];

    return \yii\helpers\ArrayHelper::merge($common, $config);
