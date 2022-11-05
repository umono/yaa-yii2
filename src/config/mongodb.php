<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2021/11/19
     * Time: 2:43 下午
     */

    return [
        'class'           => '\yii\mongodb\Connection',
        'dsn'             => $_ENV['MONGO_DB_DSN'],
        'options'         => [
            "username" => $_ENV['MONGO_DB_USERNAME'],
            "password" => $_ENV['MONGO_DB_PASSWORD'],
        ],
        'enableLogging'   => YII_ENV === 'dev', // 启用日志记录
        'enableProfiling' => YII_ENV === 'dev', // 启用分析
    ];