<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/8
     * Time: 3:59 PM
     */

    namespace app\modules\website;



    use umono\multiple\modules\AbstractModuleBootstrap;

    class ModuleBootstrap extends AbstractModuleBootstrap
    {
        public function bootstrap($app)
        {
            parent::bootstrap($app);

            if ($app instanceof \yii\web\Application) {

                \Yii::$app->getErrorHandler()->errorAction = 'website/site/error';
            }
        }
    }