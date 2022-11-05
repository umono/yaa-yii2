<?php

    namespace app\modules\backend\api\models\admin;


    use umono\multiple\helpers\ImportHelper;
    use umono\multiple\helpers\OverHelper;

    class AdminImport extends \app\common\models\admin\Admin
    {
        public static function importCreate()
        {
            OverHelper::veryLong();
            $importArr = ImportHelper::excelRead([1]);
            $progress  = new ImportHelper();
            $progress->iniData(count($importArr));
            $tr       = \Yii::$app->db->beginTransaction();
            //默认密码6个0
            $password = \Yii::$app->getSecurity()->generatePasswordHash('000000', 5);
            unset($arr);
            try {
                foreach ($importArr as $k => $v) {
                    $progress->setValue($k);
                    if (empty($v['B']) || empty($v['C']) || empty($v['E'])) {
                        continue;
                    }
                    $id = (int)($v['A'] ?? '0');
                    if ($id) {
                        $new_model = AdminImport::findOne(['id' => $id]);
                    } else {
                        $new_model = new AdminImport();
                    }
                    $new_model->username     = trim($v['C']) . trim($v['B']);
                    $new_model->phone        = trim($v['B']);
                    $new_model->auth_key     = \Yii::$app->getSecurity()
                        ->generateRandomString();
                    $new_model->password     = $password;
                    $new_model->name         = trim($v['C']);
                    $new_model->adminGroupId = (int)trim($v['D']);
                    $new_model->status       = 10;
                    $new_model->save();
                    unset($new_model);
                }
                unset($importArr);
                $tr->commit();
                return self::success(SUCCESS);
            } catch (\Exception $e) {
                $tr->rollBack();
                return self::error($e->getMessage());
            }
        }
    }