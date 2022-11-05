<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/8
     * Time: 4:20 PM
     */

    namespace app\modules\website\controllers;


    use app\modules\website\Controller;
    use Yii;

    class SiteController extends Controller
    {
        private function apiSet(): array
        {
            return [
                'base' => $_ENV['APP_NAME'],
            ];
        }

        public function actions()
        {
            $actions = [];
            $apiSet  = $this->apiSet();
            foreach ($apiSet as $k => $api) {
                $actions[$k . '-doc'] = [
                    'class'   => 'light\swagger\SwaggerAction',
                    'restUrl' => \yii\helpers\Url::to(['/site/api-' . $k], true),
                ];
                $actions['api-' . $k] = [
                    'class'   => 'light\swagger\SwaggerApiAction',
                    'scanDir' => [
                        Yii::getAlias('@app/modules/api/' . $k . '/swagger'),
                        Yii::getAlias('@app/modules/api/' . $k . '/controllers'),
                        Yii::getAlias('@app/modules/api/' . $k . '/models'),
                    ],
                ];
            }
            if (!YII_DEBUG) {
                unset($actions);
            }
            return $actions ?? '';
        }

        public function actionIndex(): string
        {

            return $this->render('index', ['apiList' => $this->apiSet(), 'home' => []]);
        }

        public function actionError(): string
        {
            return $this->render(
                'error',
                [
                    'exception' => \Yii::$app->getErrorHandler()->exception,
                ]
            );
        }
    }