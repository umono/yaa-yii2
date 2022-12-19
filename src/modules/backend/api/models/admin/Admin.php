<?php

    namespace app\modules\backend\api\models\admin;


    use GrahamCampbell\ResultType\Success;
    use yii\db\Exception;

    class Admin extends \app\common\models\admin\Admin
    {
        public function attributeLabels()
        {
            return [
                'id'           => 'ID',
                'username'     => '用户名',
                'phone'        => '手机号码',
                'email'        => '邮箱',
                'name'         => '姓名',
                'avatar'       => '头像',
                'adminGroupId' => '所属部门',
                'status'       => '状态',
                'created_at'   => '创建时间',
                'updated_at'   => '更新时间',
            ];
        }

        public static function transFormatData(
            $model,
            $info = false,
            $options = []
        ) {
            unset($model['password_hash']);
            unset($model['auth_key']);
            unset($model['password_reset_token']);
            if (empty($model['avatar'])) {
                $model['avatar'] = '/images/avatar.png';
            }
            if (!empty($model['adminGroup'])) {
                $model['adminGroupId'] = $model['adminGroup']['name'] ?? '';
            }

            return $model;

        }


        public static function updateAdmin($id, $param)
        {
            $admin = Admin::findOne(['id' => $id]);
            $admin->setScenario('edit');
            $tr = \Yii::$app->db->beginTransaction();
            try {
                $admin->load($param, '');
                $admin->save();
                $tr->commit();

                return self::success(CHANGE_SUCCESS, $admin);
            } catch (Exception $e) {
                return self::error($e->getMessage());
            }
        }


        public static function create($param)
        {
            if (strlen($param['password']) >= 20 || strlen($param['password']) <= 5) {
                self::error('密码长度应该在5-20个字符之间。');
            }

            $tr = \Yii::$app->db->beginTransaction();
            try {
                $admin = new Admin();
                $admin->setScenario('create');
                $admin->load($param, '');
                $admin->save();
                $tr->commit();
                if (empty($admin->avatar)) {
                    $admin->avatar = '/images/avatar.png';
                }

                return self::success(SUCCESS, $admin);
            } catch (Exception $e) {
                return self::error($e->getMessage());
            }
        }

        public static function updatePassword($param)
        {
            $model = Admin::findOne(['id' => $param['id'] ?? -1]);
            if (!empty($model)) {
                if (!empty($param['password'])){
                    $model->password = $param['password'];
                    $model->passwordConfirm = true;
                    $model->save();
                }
                unset($model);
            }

            return self::success(SUCCESS);
        }
    }
