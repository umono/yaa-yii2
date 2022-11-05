<?php

	use yii\db\Migration;

	/**
	 * Handles the creation of table `{{%logs}}`.
	 */
	class m180601_035117_create_logs_table extends Migration
	{
		/**
		 * {@inheritdoc}
		 */
		public function safeUp()
		{
			$this->createTable('{{%logs}}', [
				'id'            => $this->primaryKey(),
				'status'        => $this->integer()->comment('状态'),
				'adminId'       => $this->integer()->comment('操作人ID'),
				'adminName'     => $this->string()->comment('操作人名称'),
				'oldAtt'        => $this->text()->comment('旧数据'),
				'newAtt'        => $this->text()->comment('新数据'),
				'params'        => $this->text()->comment('参数'),
				'exception'     => $this->text()->comment('异常信息'),
				'remoteAddress' => $this->string(32)->comment('IP 地址'),
				'method'        => $this->string(50)->comment('方法'),
				'type'          => $this->string(32)->comment('类型'),
				'fromType'      => $this->string(32)->comment('来源类型'),
				'action'        => $this->string()->comment('操作'),
				'_action'       => $this->string()->comment('操作描述'),
				'userAgent'     => $this->string(500)->comment('浏览器'),
				'classModel'    => $this->string()->comment('模型类'),
				'is_del'        => $this->boolean()->defaultValue(false)->comment('是否删除'),
				'created_at'    => $this->dateTime(),
				'updated_at'    => $this->dateTime(),
			]);
			$this->createIndex('is_del', '{{%logs}}', 'is_del');
			$this->createIndex('adminId', '{{%logs}}', 'adminId');
			$this->createIndex('remoteAddress', '{{%logs}}', 'remoteAddress');
			$this->createIndex('fromType', '{{%logs}}', 'fromType');
			$this->createIndex('method', '{{%logs}}', 'method');
		}

		/**
		 * {@inheritdoc}
		 */
		public function safeDown()
		{
			$this->dropTable('{{%logs}}');
		}
	}
