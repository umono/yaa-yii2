<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use umono\multiple\helpers\ExportHelper;

    class ExportController extends Controller
    {
        /**
         * @throws \yii\web\BadRequestHttpException
         */
        public function actionSelect()
        {
            return ExportHelper::exportSelect($this->param);
        }

        public function actionAll()
        {
            return ExportHelper::exportAll($this->param);
        }
    }