<?php

    namespace app\modules;


    /**
     *  需要注意：url的匹配规则上要会被模块的优先级会被替换
     */
    class ModulesConfig extends \umono\multiple\ModulesConfig
    {
        public static function bootstrap(): array
        {

            return [
                'log',
                \app\modules\api\base\ModuleBootstrap::class,
                \app\modules\backend\api\ModuleBootstrap::class,
                \app\modules\backend\web\ModuleBootstrap::class,
                \app\modules\website\ModuleBootstrap::class,
            ];
        }

        public static function modules(): array
        {

            return [
                \app\modules\api\base\Module::getModuleId()    => \app\modules\api\base\Module::class,
                \app\modules\backend\api\Module::getModuleId() => \app\modules\backend\api\Module::class,
                \app\modules\backend\web\Module::getModuleId() => \app\modules\backend\web\Module::class,
                \app\modules\website\Module::getModuleId()     => \app\modules\website\Module::class,
            ];
        }
    }