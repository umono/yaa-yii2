<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/5
     * Time: 5:53 PM
     */

    $log = require(__DIR__ . '/log.php');
    $db  = require(__DIR__ . '/db.php');

    $common = [
        'name'        => $_ENV['APP_NAME'],
        'language'    => 'zh-CN',
        'timeZone'    => 'UTC',
        'basePath'    => dirname(__DIR__) . '/',
        'vendorPath'  => dirname(__DIR__) . '/../vendor',
        'runtimePath' => dirname(__DIR__) . '/../runtime',

        'bootstrap' => \app\modules\ModulesConfig::bootstrap(),

        'aliases' => [
            '@base'           => dirname(__DIR__) . '/../',
            '@app'            => dirname(__DIR__) . '/',
            '@app/web'        => __DIR__ . '/../../public',
            '@app/migrations' => __DIR__ . '/../database/migrations',
        ],

        "modules" => \app\modules\ModulesConfig::modules(),

        'components' => [
            'db'         => $db,
            'security'   => [
                'passwordHashStrategy' => 'password_hash',
            ],
            'mailer'     => [
                'class'            => \yii\swiftmailer\Mailer::class,
                'useFileTransport' => false,
                'viewPath'         => '@app/common/mail',
                'transport'        => [
                    'class'      => 'Swift_SmtpTransport',
                    'host'       => $_ENV['EMAIL_HOST'],
                    'username'   => $_ENV['EMAIL_USERNAME'],
                    'password'   => $_ENV['EMAIL_PASSWORD'],
                    'port'       => $_ENV['EMAIL_PORT'],
                    'encryption' => $_ENV['EMAIL_ENCRYPTION'],
                ],
                'messageConfig'    => [
                    'charset' => 'UTF-8',
                    'from'    => [$_ENV['EMAIL_FROM_KEY'] => $_ENV['EMAIL_FROM_VALUE']],
                ],
            ],
            'log'        => $log,
            'cache'      => [
                'class' => yii\caching\FileCache::class,
            ],
            'urlManager' => [
                'showScriptName'      => false,
                'enablePrettyUrl'     => true,
                'enableStrictParsing' => true,
                'normalizer'          => [
                    'class' => yii\web\UrlNormalizer::class,
                ],
                'rules'               => [],
            ],
        ],
    ];

    $common['components']['redis'] = [
        'class'    => yii\redis\Connection::class,
        'hostname' => $_ENV['REDIS_HOST'],
        'port'     => $_ENV['REDIS_PORT'],
        'password' => $_ENV['REDIS_PASSWORD'],
        'database' => 0,
    ];;

    /**
     * @param array $common
     * @return array
     */
    function extracted(array $common): array
    {
        if (YII_DEBUG) {
            $common['bootstrap'][]      = 'debug';
            $common['modules']['debug'] = [
                'class'      => 'yii\debug\Module',
                'allowedIPs' => ['*'],
            ];

            $common['bootstrap'][]    = 'gii';
            $common['modules']['gii'] = [
                'class'      => 'yii\gii\Module',
                'allowedIPs' => ['*'],
            ];
        }


        return $common;
    }

    return extracted($common);