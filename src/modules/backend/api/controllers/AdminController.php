<?php

    namespace app\modules\backend\api\controllers;


    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\admin\Admin;
    use app\modules\backend\api\models\admin\AdminGroup;
    use app\modules\backend\api\models\admin\AdminImport;

    class AdminController extends Controller
    {
        public function actionIndex()
        {
            $get    = $this->get;
            $select = $get['select'] ?? [];
            if (empty($select)) {
                $select = [
                    'id',
                    'phone',
                    'username',
                    'adminGroupId',
                    'name',
                    'avatar',
                    'status',
                    'email',
                    'updated_at',
                    'created_at',
                ];
            }
            $andWhere = [
                ['like', 'phone', $get['phone'] ?? ''],
                ['like', 'username', $get['username'] ?? ''],
            ];
            return Admin::page()
                ->setColumn($select)
                ->setSelectTableColumn($select)
                ->getTablesParam()
                ->andWhere($andWhere)
                ->toTableDataArray();
        }

        // 单个创建用户
        public function actionCreate()
        {
            return Admin::create($this->param);
        }

        public function actionUpdate()
        {
            return Admin::updateAdmin($this->param['id'], $this->param);
        }

        public function actionView($id): array
        {
            $admin = Admin::find()->where(['id' => $id])->asArray()->one();
            unset($admin['password']);
            return [
                'admin'  => $admin,
                'groups' => AdminGroup::backCacheList()
                ,
            ];
        }

        public function actionChangePassword()
        {
            return Admin::updatePassword($this->param);
        }


        // 导入数据进行处理
        public function actionImport()
        {
            return AdminImport::importCreate();
        }

        // 获取文件导入模板
        public function actionImportPreview(): string
        {
            return $_ENV['APP_URL'] . "/template/excel/员工模板.xlsx";
        }

        // 冻结
        public function actionFreeze()
        {
            $id    = $this->param['id'] ?? 0;
            $model = Admin::findOne($id);
            if (empty($model)) {
                $this->error('当前用户不存在');
            }
            if ($model->status == Admin::STATUS_ACTIVE) {
                $model->status = Admin::STATUS_FREEZE;
            } else {
                $model->status = Admin::STATUS_ACTIVE;
            }
            $model->save();
            return $this->success(SUCCESS, $model->status);
        }

        public function verbs()
        {
            return [
                'index'  => ['GET'],
                'update' => [
                    'POST',
                ],
                'create' => [
                    'POST',
                ],
                'view'   => [
                    'GET',
                ],
                'import' => ['POST'],
                'freeze' => ['POST'],
            ];
        }
    }
