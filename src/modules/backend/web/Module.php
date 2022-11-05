<?php


    namespace app\modules\backend\web;

    use umono\multiple\modules\AbstractModule;

    class Module extends AbstractModule
    {
        public static $moduleId = 'web';
        public static $urlPrefix = 'admin';


        public static function getRouteRules(): array
        {
            return [
                ''           => 'site/index',
                '<url:(.*)>' => 'site/index',
            ];
        }

    }