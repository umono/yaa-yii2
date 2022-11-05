<?php

	use yii\db\Migration;

	/**
	 * Handles the creation of table `{{%delete_msg}}`.
	 */
	class m211116_084016_create_delete_msg_table extends Migration
	{
		/**
		 * {@inheritdoc}
		 */
		public function safeUp()
		{
			$tableOptions = null;
			if ($this->db->driverName === 'mysql') {
				$tableOptions
					= 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB comment "删除记录表"';
			}
			$this->createTable('{{%delete_msg}}', [
				'id'         => $this->primaryKey(),
				'admin_id'   => $this->integer()->comment('操作人'),
				'msg'        => $this->string()->comment('删除原因'),
				'type_id'    => $this->integer()->comment('类型ID'),
				'type_model' => $this->string()->comment('类型Model'),
				'delParam'   => $this->string()->comment('删除参数'),
				'is_del'     => $this->boolean()->defaultValue(false)->comment('是否删除'),
				'created_at' => $this->dateTime()->comment('创建时间'),
				'updated_at' => $this->dateTime()->comment('更新时间'),
			], $tableOptions);
			$this->createIndex('is_del', '{{%delete_msg}}', 'is_del');
			$this->createIndex('admin_id', '{{%delete_msg}}', 'admin_id');
			$this->createIndex('type_id', '{{%delete_msg}}', 'type_id');
			$this->createIndex('type_model', '{{%delete_msg}}', 'type_model');
		}

		/**
		 * {@inheritdoc}
		 */
		public function safeDown()
		{
			$this->dropTable('{{%delete_msg}}');
		}
	}
