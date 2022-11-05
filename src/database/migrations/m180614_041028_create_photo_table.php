<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `photo`.
     */
    class m180614_041028_create_photo_table extends Migration
    {
        private $table = '{{%photo}}';

        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  ENGINE=InnoDB comment "图片表"';
            }
            $this->createTable(
                $this->table, [
                'id'         => $this->primaryKey(),
                'path'       => $this->string()->notNull()->defaultValue('')->comment('路劲'),
                'title'      => $this->string()->notNull()->defaultValue('')->comment('文件名'),
                'url'        => $this->string()->notNull()->defaultValue('')->comment('图片的URL'),
                'user_id'    => $this->integer()->notNull()->defaultValue(0)->comment('用户ID'),
                'type_id'    => $this->string(50)->notNull()->defaultValue(0)->comment('关联类型的ID'),
                'type_model' => $this->string()->notNull()->defaultValue('')->comment('类型类'),
                'status'     => $this->integer(1)->comment('状态0 无用 1使用'),
                'region'     => $this->integer(1)->comment("本地9"),
                'version'    => $this->string()->comment("当前提交的信息作为唯一标识 使用状态"),
                'created_at' => $this->dateTime()->comment('创建时间'),
                'updated_at' => $this->dateTime()->comment('修改时间'),
            ], $tableOptions);
			$this->createIndex('user_id', '{{%photo}}', 'user_id');
			$this->createIndex('type_id', '{{%photo}}', 'type_id');
			$this->createIndex('type_model', '{{%photo}}', 'type_model');
			$this->createIndex('path', '{{%photo}}', 'path');
			$this->createIndex('region', '{{%photo}}', 'region');
			$this->createIndex('status', '{{%photo}}', 'status');
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable($this->table);
        }
    }
