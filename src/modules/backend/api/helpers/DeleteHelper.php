<?php

    namespace app\modules\backend\api\helpers;

    use app\common\models\other\DeleteMsg;

    class DeleteHelper extends \umono\multiple\helpers\DeleteHelper
    {
        public static function callDeleteMsg($msg, $ids, $modelClass)
        {
            $deleteMsgModel = new DeleteMsg();
            foreach ($ids as $id) {
                $m = $deleteMsgModel::findOne(
                    [
                        'type_id'    => $id,
                        'type_model' => $modelClass,
                    ]
                );
                if (empty($m)) {
                    $deleteMsg             = clone $deleteMsgModel;
                    $deleteMsg->admin_id   = \Yii::$app->user->id;
                    $deleteMsg->type_id    = $id;
                    $deleteMsg->type_model = $modelClass;
                    $deleteMsg->msg        = $msg;
                    $deleteMsg->save();
                    unset($deleteMsg);
                } else {
                    DeleteMsg::error('当前数据中存在已删除！');
                }
                unset($m);
            }

        }
    }