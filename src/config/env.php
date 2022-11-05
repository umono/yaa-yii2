<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/5
     * Time: 6:03 PM
     */
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/../');
    $dotenv->safeLoad();
    $dotenv->required(['DB_DSN', 'DB_USERNAME', 'DB_PASSWORD']);

    defined('YII_DEBUG') or define('YII_DEBUG', $_ENV['APP_DEBUG'] == 1);
    defined('YII_ENV') or define('YII_ENV', $_ENV['APP_ENV']);

