<?php

    namespace app\common\models\admin;

    use app\common\models\Model;

    /**
     * This is the model class for table "{{%logs}}".
     *
     * @property int         $id
     * @property int|null    $status        状态
     * @property int|null    $adminId       操作人ID
     * @property string|null $adminName     操作人名称
     * @property string|null $oldAtt        旧数据
     * @property string|null $newAtt        新数据
     * @property string|null $params        参数
     * @property string|null $exception     异常信息
     * @property string|null $remoteAddress IP 地址
     * @property string|null $method        方法
     * @property string|null $type          类型
     * @property string|null $fromType      来源类型
     * @property string|null $action        操作
     * @property string|null $_action       操作描述
     * @property string|null $userAgent     浏览器
     * @property string|null $classModel    模型类
     * @property int|null    $is_del        是否删除
     * @property string|null $created_at
     * @property string|null $updated_at
     */
    class AdminLog extends Model
    {
        public const STATUS_FAIL = 0;
        public const STATUS_SUCCESS = 1;

        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%logs}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['status', 'adminId', 'is_del'], 'integer'],
                [['oldAtt', 'newAtt', 'params', 'exception'], 'string'],
                [['created_at', 'updated_at'], 'safe'],
                [['adminName', 'action', '_action', 'classModel'], 'string', 'max' => 255],
                [['remoteAddress', 'type', 'fromType'], 'string', 'max' => 32],
                [['method'], 'string', 'max' => 50],
                [['userAgent'], 'string', 'max' => 500],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id'            => 'ID',
                'status'        => '状态',
                'adminId'       => '操作人ID',
                'adminName'     => '操作人名称',
                'oldAtt'        => '旧数据',
                'newAtt'        => '新数据',
                'params'        => '参数',
                'exception'     => '异常信息',
                'remoteAddress' => 'IP 地址',
                'method'        => '方法',
                'type'          => '类型',
                'fromType'      => '来源类型',
                'action'        => '操作',
                '_action'       => '操作描述',
                'userAgent'     => '浏览器',
                'classModel'    => '模型类',
                'is_del'        => '是否删除',
                'created_at'    => 'Created At',
                'updated_at'    => 'Updated At',
            ];
        }
    }