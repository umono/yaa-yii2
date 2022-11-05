<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%setting}}`.
     */
    class m190418_094102_create_setting_table extends Migration
    {
        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB comment "设置信息"';
            }
            $this->createTable(
                '{{%setting}}', [
                'id'         => $this->primaryKey(),
                'type'       => $this->integer(3)->comment('配置类型'),
                'body'       => $this->text()->comment('内容'),
                'des'        => $this->string()->comment('描述'),
                'status'     => $this->integer(1)->defaultValue(0)->comment('是否启用'),
                'validate'   => $this->integer(1)->defaultValue(0)->comment('是否验证'),
                'created_at' => $this->dateTime()->comment('创建时间'),
                'updated_at' => $this->dateTime()->comment('更新时间'),
            ], $tableOptions);
			$this->createIndex('type', '{{%setting}}', 'type');
			$this->createIndex('status', '{{%setting}}', 'status');
			$this->createIndex('validate', '{{%setting}}', 'validate');
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable('{{%setting}}');
        }
    }
