<?php

    namespace app\modules\backend\api;

    use app\modules\backend\api\models\admin\Admin;
    use yii\web\User;
    use umono\multiple\modules\ApiBaseModule;

    /**
     * api module definition class
     */
    class Module extends ApiBaseModule
    {
        public static $moduleId = 'api';
        public static $urlPrefix = 'admin/api';

        public static function getUserComponent(): array
        {
            return [
                'class'           => User::class,
                'identityClass'   => Admin::class,
                'enableAutoLogin' => false,
                'enableSession'   => false,
                'loginUrl'        => null,
            ];
        }

        public $startTime;

        public function addInit200Where(): bool
        {
            $path = \Yii::$app->request->getPathInfo();
            $p    = explode('/', $path);

            return !(in_array($path, $this->downloadFree())
                || in_array($p[3]??'', $this->downloadFree()));
        }

        public function downloadFree(): array
        {
            return [
                'admin/api/export/all',
                'admin/api/export/select',
                'import-data',
                'import-preview',
                'export-data',
                'export-file',
                'export',
            ];
        }
    }
