<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use \umono\multiple\helpers\DeleteHelper;

    class TestController extends Controller
    {
        public function actionIndex()
        {
            return DeleteHelper::$bind;
        }
    }