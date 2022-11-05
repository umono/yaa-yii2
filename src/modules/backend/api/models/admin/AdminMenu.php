<?php

    namespace app\modules\backend\api\models\admin;


    use yii\db\Exception;
    use yii\helpers\ArrayHelper;

    class AdminMenu extends \app\common\models\admin\AdminMenu
    {
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'name'       => '菜单名称',
                //'typeName'   => '描述0/页面1/功能2',
                //'typeDes'    => '描述信息',
                'actionId'   => '操作权限Url',
                //'childrenId' => '节点',
                'sort'       => '顺序',
                'iconName'   => '图标名称',
                'status'     => '0关/1开',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
            ];
        }

        // 返回menuKey数据
        public static function handlerMenuBack($menus)
        {
            $menuKey = [];
            foreach ($menus as $v) {
                $k                  = str_replace("parent_", '', $v['key']);
                $menuKey[$v['key']] = [$k, $v['label']];
                if (!empty($v['children'])) {
                    foreach ($v['children'] as $child) {
                        $_k                     = str_replace("parent_", '', $child['key']);
                        $menuKey[$child['key']] = [$_k, $child['label'], $child['pathKey']];
                    }
                }
            }
            unset($menus);
            return $menuKey;
        }

        public static function viewFind($id)
        {
            return AdminMenu::find()->where(['id' => $id])->with(['child.child'])->asArray()->one();
        }

        // 菜单仅仅2级
        public static function createUpdate($param)
        {
            $model = AdminMenu::findOne(['id' => $param['id'] ?? -1]);
            if (empty($model)) {
                $model = new AdminMenu();
            }

            $tr = \Yii::$app->db->beginTransaction();
            try {
                $model->load($param, '');
                $model->typeName   = static::TYPE_NAME_PARENT;
                $model->childrenId = 0;
                $model->save();
                // 子菜单
                $menuModel = new AdminMenu();
                static::saveChild($param, $menuModel, $model->typeName + 1, $model->id);
                // 删除项
                $delArr = ArrayHelper::merge($param['deleteMenuIds'], $param['deletePowerIds']);
                AdminMenu::deleteAll(['id' => $delArr]);
                AdminMenu::deleteAll(['childrenId' => $param['deleteMenuIds']]);
                // 清除菜单缓存
                AdminMenu::clearCache();

                $groupIds = AdminGroup::find()->select('id')->column();
                foreach ($groupIds as $id) {
                    AdminGroup::clearPermissionsCache($id);
                }


                unset($menuModel);
                unset($model);
                $tr->commit();
                return self::success(SUCCESS);
            } catch (Exception $e) {
                $tr->rollBack();
                return self::error($e->getMessage());
            }
        }

        public static function saveChild($param, $menuModel, $type, $parenId)
        {
            if (!isset($param['child']) || !$param['child']) {
                return false;
            }
            foreach ($param['child'] as $child) {
                $_menuModel = $menuModel::findOne(['id' => $child['id'] ?? -1]);
                if (empty($_menuModel)) {
                    $_menuModel = clone $menuModel;
                }
                $_menuModel->load($child, '');
                $_menuModel->typeName   = $type;
                $_menuModel->childrenId = $parenId;
                $_menuModel->save();
                static::saveChild($child, $menuModel, $type + 1, $_menuModel->id);
                unset($_menuModel);
            }
        }
    }