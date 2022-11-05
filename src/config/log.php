<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/5
     * Time: 5:58 PM
     */
    return [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets'    => [
            [
                'class'       => 'yii\log\FileTarget',
                'levels'      => ['error', 'warning'],
                'logVars'     => ['*'],
                'maxFileSize' => 1024 * 5,
                'maxLogFiles' => 100,
                'logFile'     => "@runtime/logs/" . date('Y-m-d') . '-app.log'
            ],
        ],
    ];