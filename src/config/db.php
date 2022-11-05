<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/5
     * Time: 5:54 PM
     */

    return [
        'class'             => yii\db\Connection::class,
        'dsn'               => $_ENV['DB_DSN']??'mysql:host=localhost;dbname=yii2',
        'username'          => $_ENV['DB_USERNAME'],
        'password'          => $_ENV['DB_PASSWORD'],
        'charset'           => 'utf8mb4',
        'tablePrefix'       => $_ENV['DB_TABLE_PREFIX']??null,
        'enableSchemaCache' => YII_ENV !== 'dev',
		// Duration of schema cache.
		'schemaCacheDuration' => 3600,
		// Name of the cache component used to store schema information
		'schemaCache' => 'cache',
    ];
