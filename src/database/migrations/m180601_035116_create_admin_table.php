<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `admin`.
     */
    class m180601_035116_create_admin_table extends Migration
    {
        private $adminTableName = '{{%admin}}';
        private $adminAccessTokenTableName = '{{%admin_access_token}}';
        private $adminGroupTableName = '{{%admin_group}}';
        private $adminGroupPermissionsTableName = '{{%admin_group_permissions}}';
        private $adminMenuTableName = '{{%admin_menu}}';

        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $tableOptions = null;
            /**
             * Admin
             */
            $this->createTable(
                $this->adminTableName, [
                'id'                   => $this->primaryKey(),
                'username'             => $this->string(64)->notNull()->unique()->comment('用户名'),
                'auth_key'             => $this->string(255)->notNull()->comment('令牌'),
                'phone'                => $this->string(11)->defaultValue('')->comment('手机号码'),
                'password'             => $this->string(255)->comment('密码'),
                'password_reset_token' => $this->string(255)->comment('重置密码的Token'),
                'email'                => $this->string(64)->comment('邮箱'),
                'name'                 => $this->string(30)->comment('姓名'),
                'avatar'               => $this->string()->defaultValue('')->comment('头像'),
                'adminGroupId'         => $this->integer()->defaultValue(0)->comment('管理组ID'),
                'status'               => $this->integer()->notNull()->defaultValue(10)->comment('状态'),
                'created_at'           => $this->dateTime()->notNull(),
                'created_id'           => $this->integer()->notNull()->defaultValue(0)->comment('创建用户'),
                'updated_at'           => $this->dateTime()->notNull(),
                'updated_id'           => $this->integer()->notNull()->defaultValue(0)->comment('修改用户'),
                'is_del'               => $this->boolean()->defaultValue(false)->comment('是否删除'),
                'is_hidden'            => $this->boolean()->defaultValue(false)->comment('是否隐藏'),
            ],  'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  ENGINE=InnoDB comment "管理员用户表"');
            $this->createIndex('phone', $this->adminTableName, 'phone', true);
            $this->createIndex('email', $this->adminTableName, 'email');
            $this->createIndex('adminGroupId', $this->adminTableName, 'adminGroupId');
            $this->createIndex('is_del', $this->adminTableName, 'is_del');

            $this->createTable(
                $this->adminAccessTokenTableName, [
                'id'            => $this->primaryKey(),
                'adminId'       => $this->integer()->notNull()->defaultValue(0)->comment('用户id'),
                'clientId'      => $this->string(50)->notNull()->defaultValue('客户端id'),
                'accessToken'   => $this->string(60)->notNull()->defaultValue('token'),
                'remoteAddress' => $this->string(50)->notNull()->defaultValue('地址ip'),
                'userAgent'     => $this->string(2048)->notNull()->defaultValue('UA'),
                'created_at'    => $this->dateTime()->notNull()->comment('创建时间'),
                'updated_at'    => $this->dateTime()->notNull()->comment('更新时间'),
            ],  'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  ENGINE=InnoDB comment "管理员AccessToken表"');

            $this->createIndex('adminId', $this->adminAccessTokenTableName, ['adminId', 'clientId']);
            $this->createIndex('accessToken', $this->adminAccessTokenTableName, ['accessToken', 'clientId']);

            $this->createTable(
                $this->adminGroupTableName, [
                'id'   => $this->primaryKey(),
                'name' => $this->string(50)->notNull()->defaultValue('名称'),
            ],  'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  ENGINE=InnoDB comment "管理组表"' . ' AUTO_INCREMENT=101');

            $this->createTable(
                $this->adminGroupPermissionsTableName, [
                'id'           => $this->primaryKey(),
                'adminGroupId' => $this->integer()->notNull()->defaultValue(0),
                'actionId'     => $this->string()->notNull()->defaultValue('操作权限Url'),
            ],  'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  ENGINE=InnoDB comment "管理组权限表"');

            $this->createIndex('adminGroupId', $this->adminGroupPermissionsTableName, 'adminGroupId');
            $this->createIndex('actionId', $this->adminGroupPermissionsTableName, 'actionId');

            $this->createTable(
                $this->adminMenuTableName, [
                'id'         => $this->primaryKey(),
                'name'       => $this->string()->comment('菜单名称'),
                'typeName'   => $this->tinyInteger(1)->comment('描述0/页面1/功能2'),
                'typeDes'    => $this->string()->comment('描述信息'),
                'actionId'   => $this->string()->comment('操作权限Url'),
                'childrenId' => $this->integer()->comment('节点'),
                'sort'       => $this->integer()->comment('顺序'),
                'iconName'   => $this->string()->comment('图标名称'),
                'status'     => $this->tinyInteger(1)->defaultValue(1)->comment('0关/1开'),
                'created_at' => $this->dateTime()->comment('创建时间'),
                'updated_at' => $this->dateTime()->comment('更新时间'),
            ],  'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  ENGINE=InnoDB comment "管理组权限表"');

            $this->createIndex('childrenId', $this->adminMenuTableName, 'childrenId');
            $this->createIndex('typeName', $this->adminMenuTableName, 'typeName');
            $this->createIndex('status', $this->adminMenuTableName, 'status');
            $this->createIndex('sort', $this->adminMenuTableName, 'sort');

            // 写入数据
            $this->batchInsert($this->adminGroupTableName, ['name'], [['开发部']]);

            $this->batchInsert(
                $this->adminTableName, [
                'phone',
                'adminGroupId',
                'password',
                'username',
                'auth_key',
                'created_at',
                'updated_at',
            ],  [
                    [
                        '9527',
                        '101',
                        Yii::$app->getSecurity()->generatePasswordHash($_ENV['APP_PASSWORD']),
                        '开发者账号',
                        \Yii::$app->getSecurity()->generateRandomString(),
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ],
                ]);
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable($this->adminTableName);
            $this->dropTable($this->adminAccessTokenTableName);
            $this->dropTable($this->adminGroupTableName);
            $this->dropTable($this->adminGroupPermissionsTableName);
        }
    }
