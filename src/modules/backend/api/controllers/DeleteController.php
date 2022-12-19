<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\helpers\DeleteHelper;
    use app\modules\backend\api\helpers\ExportDeleteHelper;

    class DeleteController extends Controller
    {
        public function actionSelect()
        {
            ExportDeleteHelper::can(ExportDeleteHelper::DELETE,$this->param);
            return $this->success(SUCCESS);
        }
    }