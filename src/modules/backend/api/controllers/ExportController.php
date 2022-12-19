<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\helpers\ExportDeleteHelper;
    use umono\multiple\helpers\ExportHelper;

    class ExportController extends Controller
    {
        /**
         * @throws \yii\web\BadRequestHttpException
         */
        public function actionSelect()
        {
            return ExportDeleteHelper::can(ExportDeleteHelper::EXPORT_SELECT, $this->param);
        }

        public function actionAll()
        {
            return ExportDeleteHelper::can(ExportDeleteHelper::EXPORT_ALL, $this->param);
        }
    }