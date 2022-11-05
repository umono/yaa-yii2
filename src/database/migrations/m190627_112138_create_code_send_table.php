<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%code_send}}`.
     */
    class m190627_112138_create_code_send_table extends Migration
    {
        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB comment "发送验证码"';
            }

            $this->createTable(
                '{{%code_send}}', [
                'id'         => $this->primaryKey(),
                'number'     => $this->string(50)->comment('号码/邮箱'),
                'type'       => $this->integer(1)->comment('类型'),
                'code'       => $this->string(20)->comment('验证码'),
                'template'   => $this->string(20)->comment('发送的模板template'),
                'status'     => $this->integer(1)->defaultValue(0)->comment('0未使用,1已使用'),
                'created_at' => $this->dateTime()->comment('发送时间'),
                'updated_at' => $this->dateTime()->comment('更新时间'),
                'lastTime'   => $this->dateTime()->comment('过期时间'),
            ], $tableOptions);
			$this->createIndex('number', 'code_send', 'number');
			$this->createIndex('type', 'code_send', 'type');
			$this->createIndex('template', 'code_send', 'template');
			$this->createIndex('status', 'code_send', 'status');
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable('{{%code_send}}');
        }
    }
