<?php

    namespace app\modules\backend\web\controllers;


    class SiteController extends \app\modules\backend\web\Controller
    {
        public function actionIndex(): string
        {
            $this->layout = false;


            return $this->render('/index');
        }

        public function actionError(): string
        {
            $this->layout = false;
            return $this->render(
                '/error', [
                'exception' => \Yii::$app->getErrorHandler()->exception,
            ]);
        }
    }