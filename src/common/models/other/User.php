<?php

    namespace app\common\models\other;

    use Yii;

    /**
     * This is the model class for table "{{%user}}".
     *
     * @property int         $id
     * @property string|null $nickName   用户昵称
     * @property string|null $name       用户姓名
     * @property string|null $_hash      HASH地址
     * @property string|null $openId     微信openId
     * @property string|null $phone      手机号码
     * @property int|null    $integral   积分数据
     * @property string|null $password   密码
     * @property string|null $avatar     头像
     * @property int|null    $status     账号状态
     * @property string|null $auth_key   权限token，登录TOKEN
     * @property int|null    $gender     性别:1男2女
     * @property int|null    $is_del     是否删除
     * @property string|null $created_at 创建时间
     * @property string|null $updated_at 更新时间
     */
    class User extends \app\common\models\Model
    {
        public $tableImageColumn = ['avatar'];

        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%user}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['integral', 'status', 'gender', 'is_del'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['nickName', 'name', 'phone'], 'string', 'max' => 20],
                [['_hash', 'openId', 'password', 'avatar', 'auth_key'], 'string', 'max' => 255],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'nickName'   => '用户昵称',
                'name'       => '用户姓名',
                '_hash'      => 'HASH地址',
                'openId'     => '微信openId',
                'phone'      => '手机号码',
                'integral'   => '积分数据',
                'password'   => '密码',
                'avatar'     => '头像',
                'status'     => '账号状态',
                'auth_key'   => '权限token，登录TOKEN',
                'gender'     => '性别:1男2女',
                'is_del'     => '是否删除',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
            ];
        }
    }
