<?php

	use yii\db\Migration;

	/**
	 * Handles the creation of table `{{%user}}`.
	 */
	class m201216_105625_create_user_table extends Migration
	{
		/**
		 * {@inheritdoc}
		 */
		public function safeUp()
		{
			$tableOptions = null;
			if ($this->db->driverName === 'mysql') {
				$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB comment "用户表"';
			}
			$this->createTable(
				'{{%user}}', [
				'id'         => $this->primaryKey(),
				'nickName'   => $this->string(20)->comment('用户昵称'),
				'name'       => $this->string(20)->comment('用户姓名'),
				'_hash'      => $this->string()->comment('HASH地址'),
				'openId'     => $this->string()->comment('微信openId'),
				'phone'      => $this->string(20)->comment('手机号码'),
				'integral'   => $this->integer()->defaultValue(0)->comment('积分数据'),
				'password'   => $this->string()->comment('密码'),
				'avatar'     => $this->string()->comment('头像'),
				'status'     => $this->tinyInteger(1)->defaultValue(1)->comment('账号状态'),
				'auth_key'   => $this->string(255)->comment('权限token，登录TOKEN'),
				'gender'     => $this->integer(1)->comment('性别:1男2女'),
				'is_del'     => $this->boolean()->defaultValue(false)->comment('是否删除'),
				'created_at' => $this->dateTime()->comment('创建时间'),
				'updated_at' => $this->dateTime()->comment('更新时间'),
			], $tableOptions);
			$this->createIndex('is_del', '{{%user}}', 'is_del');
			$this->createIndex('phone', '{{%user}}', 'phone');
			$this->createIndex('gender', '{{%user}}', 'gender');
		}

		/**
		 * {@inheritdoc}
		 */
		public function safeDown()
		{
			$this->dropTable('{{%user}}');
		}
	}
