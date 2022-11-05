<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%dict}}`.
     */
    class m201224_090740_create_dict_table extends Migration
    {
        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB comment "字典表"';
            }
            $this->createTable(
                '{{%dict}}', [
                'id'         => $this->primaryKey(),
                'type'       => $this->integer(2)->comment('字典类型'),
                'name'       => $this->string(20)->comment('名称'),
                'value'      => $this->string(50)->comment('值'),
                'region'     => $this->string(20)->comment('区域'),
                'created_at' => $this->dateTime()->comment('创建时间'),
                'updated_at' => $this->dateTime()->comment('更新时间'),
            ], $tableOptions);
			$this->createIndex('type', '{{%dict}}', 'type');
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable('{{%dict}}');
        }
    }
