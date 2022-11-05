<?php

    namespace app\modules\backend\api\models\admin;


    class AdminGroup extends \app\common\models\admin\AdminGroup
    {
        // 获取某个部门的菜单权限数据
        public static function byMenuRole($id)
        {
            $adminGroup    = AdminGroup::findOne(['id' => $id]);
            $permissions   = [];
            $adminGroupArr = [];
            if ($adminGroup) {
                $adminGroupArr = $adminGroup->toArray([], ['permissions']);
                $permissions   = $adminGroupArr['permissions'];
            }
            unset($adminGroup);

            $menus = AdminMenu::backCacheList(['childrenId' => 0], ['children.children']);

            $menuRole = [];
            foreach ($menus as $v) {
                $_role = [
                    'name'      => $v['name'],
                    'sumRole'   => 0,
                    'own'       => 0,
                ];

                foreach ($v['children'] as $child) {
                    $_newChild        = [
                        'name'     => $child['name'],
                        'actionId' => $child['actionId'],
                        'checked'  => false,
                    ];
                    $_role['sumRole'] += 1;
                    if (in_array($child['actionId'], $permissions)) {
                        $_newChild['checked'] = true;
                        $_role['own']         += 1;
                    }

                    foreach ($child['children'] as $_child) {
                        $haveRole             = in_array($_child['actionId'], $permissions);
                        $_newChild['child'][] = [
                            'name'     => $_child['name'],
                            'typeDes'  => $_child['typeDes'],
                            'actionId' => $_child['actionId'],
                            'checked'  => $haveRole,
                        ];
                        $_role['sumRole']     += 1;
                        if ($haveRole) {
                            $_role['own'] += 1;
                        }
                    }
                    $_role['child'][] = $_newChild;
                }
                $_role['selectAll'] = $_role['own'] == $_role['sumRole'];
                $menuRole[]         = $_role;
            }
            unset($menus);
            return [
                'id'       => $adminGroupArr,
                'name'     => $adminGroupArr['name']??'',
                'menuRole' => $menuRole,
            ];
        }

        // 创建与更新
        public static function createUpdate($param)
        {
            $permissions = static::handlerParam($param['data']);

            $model = AdminGroup::findOne(['id' => $param['id'] ?? -1]);
            if (empty($model)) {
                $model = new AdminGroup();
            }
            $param['permissions'] = $permissions;
            $model->load($param, '');
            $model->save();
            static::clearPermissionsCache($model->id);

            return self::success(SUCCESS);
        }

        private static function handlerParam($arr)
        {
            $permissions = [];
            foreach ($arr as $v) {
                foreach ($v['child'] as $child) {
                    if ($child['checked'] === true) {
                        $permissions[] = $child['actionId'];
                    }
                    if (isset($child['child'])) {
                        foreach ($child['child'] as $_child) {
                            if ($_child['checked'] === true) {
                                $permissions[] = $_child['actionId'];
                            }
                        }
                    }
                }
            }
            unset($arr);
            return $permissions;
        }
    }