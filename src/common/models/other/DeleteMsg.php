<?php

    namespace app\common\models\other;

    use Yii;

    /**
     * This is the model class for table "{{%delete_msg}}".
     *
     * @property int         $id
     * @property int|null    $admin_id   操作人
     * @property string|null $msg        删除原因
     * @property int|null    $type_id    类型ID
     * @property string|null $type_model 类型Model
     * @property string|null $delParam   删除参数
     * @property int|null    $is_del     是否删除
     * @property string|null $created_at 创建时间
     * @property string|null $updated_at 更新时间
     */
    class DeleteMsg extends \app\common\models\Model
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%delete_msg}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['admin_id', 'type_id', 'is_del'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['msg', 'type_model', 'delParam'], 'string', 'max' => 255],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'admin_id'   => '操作人',
                'msg'        => '删除原因',
                'type_id'    => '类型ID',
                'type_model' => '类型Model',
                'delParam'   => '删除参数',
                'is_del'     => '是否删除',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
            ];
        }
    }