<?php

    namespace app\modules\backend\api\helpers;

    use app\common\models\admin\AdminGroup;
    use app\modules\backend\api\helpers\DeleteHelper;
    use app\modules\backend\api\models\other\User;
    use umono\multiple\helpers\ExportHelper;
    use umono\multiple\interfacing\ExportDelete;
    use yii\helpers\Inflector;
    use yii\web\ForbiddenHttpException;

    class ExportDeleteHelper
    {
        const DELETE = 'delete';
        const EXPORT_SELECT = 'export-select';
        const EXPORT_ALL = 'export-all';

        public static function can($action, $param)
        {
            $model = ExportDelete::getModelClass($param['uid']);

            $name = $model::camel2id();

            $url = $name . '/' . $action;

            if (\Yii::$app->user->id !== 1) {
                $adminGroupId = \Yii::$app->user->getIdentity()->adminGroupId;

                $permissions = AdminGroup::getPermissionsById($adminGroupId);

                if (!AdminGroup::checkUrlInPermissions($url, $permissions)) {
                    throw new ForbiddenHttpException('您没有权限进行此操作');
                }
            }

            switch ($action) {
                case self::DELETE:
                    DeleteHelper::go($param);
                    break;
                case self::EXPORT_SELECT:
                    return ExportHelper::exportSelect($param);
                case self::EXPORT_ALL:
                    return ExportHelper::exportAll($param);
            }
        }
    }