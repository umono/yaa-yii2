<?php

    namespace app\modules\backend\api\helpers;

    class MenuDataHelper
    {
        public static function getColumnArr(): array
        {
            return [
                'id',
                'name',
                'typeName',
                'typeDes',
                'actionId',
                'childrenId',
                'sort',
                'iconName',
                'status',
                'created_at',
                'updated_at',
            ];
        }

        public static function backAll(): array
        {
            $time = date('Y-m-d H:i:s');
            return [
                [1, '仪表盘', 0, null, 'home', 0, 1, 'Home24Filled', 1, $time, $time],
                [2, '人事管理', 0, null, 'admin', 0, 2, 'PeopleAudience24Filled', 1, $time, $time],
                [3, '菜单管理', 0, null, 'menu', 0, 3, 'AppsList24Filled', 1, $time, $time],

                [4, '控制台', 1, '一些基本的信息', 'home/index', 1, 1, null, 1, $time, $time],
                [5, '员工', 1, '员工的数据页面', 'admin/index', 2, 1, null, 1, $time, $time],
                [6, '部门', 1, '部门的数据页面', 'admin-group/index', 2, 2, null, 1, $time, $time],
                [7, '操作记录', 1, '后台操作的一些记录', 'admin-log/index', 2, 3, null, 1, $time, $time],
                
                [8, '菜单列表', 1, '菜单的数据页面', 'menu/index', 3, 1, null, 1, $time, $time],


                [9, '员工数据查看', 2, '修改更新员工数据', 'admin/view', 5, null, null, 1, $time, $time],
                [10, '员工编辑', 2, '修改更新员工数据', 'admin/update', 5, null, null, 1, $time, $time],
                [11, '员工创建', 2, '创建员工数据', 'admin/create', 5, null, null, 1, $time, $time],
                [12, '员工冻结', 2, '冻结员工账号', 'admin/freeze', 5, null, null, 1, $time, $time],
                [13, '修改员工密码', 2, '修改员工密码', 'admin/change-password', 5, null, null, 1, $time, $time],
                [14, '员工数据删除', 2, '删除员工数据', 'admin/delete', 5, null, null, 1, $time, $time],
                [15, '员工数据导出所选', 2, '导出员工数据', 'admin/export-select', 5, null, null, 1, $time, $time],
                [16, '员工数据导出全部', 2, '导出员工数据', 'admin/export', 5, null, null, 1, $time, $time],

                [17, '部门数据查看', 2, '部门的数据查看', 'admin-group/view', 6, null, null, 1, $time, $time],
                [18, '部门创建', 2, '创建部门数据', 'admin-group/create', 6, null, null, 1, $time, $time],
                [19, '部门更新', 2, '更新或修改部门数据', 'admin-group/update', 6, null, null, 1, $time, $time],
                [20, '部门删除', 2, '删除部门信息数据', 'admin-group/delete', 6, null, null, 1, $time, $time],
                [21, '部门导出所选数据', 2, '导出所选数据', 'admin-group/export-select', 6, null, null, 1, $time, $time],
                [22, '部门导出全部数据', 2, '导出全部数据', 'admin-group/export-all', 6, null, null, 1, $time, $time],

                [23, '菜单列表创建', 2, '创建菜单数据', 'menu/create', 8, null, null, 1, $time, $time],
                [24, '菜单列表编辑', 2, '修改更新菜单数据', 'menu/update', 8, null, null, 1, $time, $time],
                [25, '菜单数据删除', 2, '删除菜单数据', 'menu/delete', 8, null, null, 1, $time, $time],
                [26, '菜单数据导出所选', 2, '导出所选数据', 'menu/export-select', 8, null, null, 1, $time, $time],
                [27, '菜单数据导出全部', 2, '导出全部数据', 'menu/export-all', 8, null, null, 1, $time, $time],

                [28, '用户管理', 0, null, 'user', 0, 6, 'People24Filled', 1, $time, $time],
                [29, '用户列表', 1, '用户列表数据', 'user/index', 17, 0, null, 1, $time, $time],
            ];
        }
    }