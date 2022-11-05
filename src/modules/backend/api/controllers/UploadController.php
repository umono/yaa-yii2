<?php

    namespace app\modules\backend\api\controllers;


    use umono\multiple\helpers\UploadHelper;
    use Yii;

    class UploadController extends \app\modules\backend\api\Controller
    {
        /**
         * 上传头像
         *
         * @throws \yii\base\Exception
         * @throws \yii\web\ForbiddenHttpException
         */
        public function actionPhoto(): array
        {
            $uploadHelper = new UploadHelper(
                'photo', Yii::$app->user->id,
                $this->param);
            $uploadHelper->setUploadFileByName('img');
            return $uploadHelper->handler();
        }

        /**
         * base64文件上传
         *
         * @throws \yii\base\Exception
         * @throws \yii\web\ForbiddenHttpException
         */
        public function actionBase64()
        {
            $uploadHelper = new UploadHelper(
                'base64', Yii::$app->user->id,
                $this->param);
            return $uploadHelper->handler();
        }

        public function verbs(): array
        {
            return [
                'photo'  => ['POST'],
                'base64' => ['POST'],
            ];
        }
    }