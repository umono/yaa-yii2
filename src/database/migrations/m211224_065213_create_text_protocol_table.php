<?php

	use yii\db\Migration;

	/**
	 * Handles the creation of table `{{%text_protocol}}`.
	 */
	class m211224_065213_create_text_protocol_table extends Migration
	{
		/**
		 * {@inheritdoc}
		 */
		public function safeUp()
		{
			$tableOptions = null;
			if ($this->db->driverName === 'mysql') {
				$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB comment "文本协议"';
			}
			$this->createTable('{{%text_protocol}}', [
				'id'         => $this->primaryKey(),
				'title'      => $this->string()->comment('标题'),
				'content'    => $this->text()->comment('内容'),
				'type'       => $this->integer(1)->comment('文本类型'),
				'status'     => $this->integer(1)->defaultValue(0)->comment('状态1显示，0不显示'),
				'sort'       => $this->integer()->comment('序号'),
				'is_del'     => $this->boolean()->defaultValue(false)->comment('是否删除'),
				'created_at' => $this->dateTime()->comment('创建时间'),
				'updated_at' => $this->dateTime()->comment('更新时间'),
			], $tableOptions);

			$this->createIndex('is_del', '{{%text_protocol}}', 'is_del');
			$this->createIndex('type', '{{%text_protocol}}', 'type');
			$this->createIndex('status', '{{%text_protocol}}', 'status');
			$this->createIndex('sort', '{{%text_protocol}}', 'sort');

		}

		/**
		 * {@inheritdoc}
		 */
		public function safeDown()
		{
			$this->dropTable('{{%text_protocol}}');
		}
	}
