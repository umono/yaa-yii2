<?php
    /**
     * Created by PhpStorm
     * USER umono
     * Date 2021/9/8 2:26 下午
     */

    namespace app\modules\api\base;


    use umono\multiple\modules\ApiBaseModule;

    class Module extends ApiBaseModule
    {
        public static $urlPrefix = 'v1/base';
        public static $moduleId = 'v1';
    }