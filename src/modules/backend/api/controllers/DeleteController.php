<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\helpers\DeleteHelper;

    class DeleteController extends Controller
    {
        public function actionSelect()
        {
            DeleteHelper::go($this->param);
            return $this->success(SUCCESS);
        }
    }