<?php

    namespace app\common\models\admin;

    use app\common\models\Model;
    use \app\modules\backend\api\AdminAesEncrypt;
    use Yii;

    /**
     * This is the model class for table "admin".
     *
     * @property int    $id
     * @property string $username             用户名
     * @property string $auth_key             令牌
     * @property string $phone                手机号码
     * @property string $password             密码
     * @property string $password_reset_token 重置密码的Token
     * @property string $email                邮箱
     * @property string $name                 姓名
     * @property string $avatar               头像
     * @property int    $adminGroupId         管理组ID
     * @property int    $status               状态
     * @property string $created_at
     * @property int    $created_id           创建用户
     * @property string $updated_at
     * @property int    $updated_id           修改用户
     * @property int    $is_del               是否删除
     * @property int    $is_hidden            是否隐藏
     */
    class Admin extends Identity
    {
        const SUPER_ADMIN_ID = 1;
        const STATUS_ACTIVE = 10; // 正常
        const STATUS_FREEZE = 1; // 冻结
        public $tableImageColumn = ['avatar'];

        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%admin}}';
        }

        public function rules()
        {
            return [
                [
                    ['adminGroupId', 'phone', 'email', 'name', 'username', 'avatar', 'password', 'passwordConfirm'],
                    'trim',
                ],
                [['username', 'phone'], 'required'],
                [['status', 'created_id', 'updated_id', 'is_del', 'is_hidden', 'adminGroupId'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['username', 'email',], 'string', 'max' => 64],
                [['auth_key', 'password', 'password_reset_token', 'avatar'], 'string', 'max' => 255],
                [['name'], 'string', 'max' => 30],
                [['phone'], 'string', 'max' => 11, 'message' => '手机号码长度不能超过11位！'],
                [['phone'], 'unique'],
                [['email'], 'email'],
                [['password', 'passwordConfirm'], 'required', 'on' => 'create', 'message' => '密码不能为空！'],
                [
                    'password',
                    'compare',
                    'compareAttribute' => 'passwordConfirm',
                    'on'               => 'create',
                    'message'          => '两次输入的密码不一致！',
                ],
                ['adminGroupId', 'required', 'on' => ['create', 'edit']],
                [
                    'adminGroupId',
                    'exist',
                    'targetClass'     => AdminGroup::class,
                    'targetAttribute' => 'id',
                    'on'              => ['create', 'edit'],
                ],
            ];
        }

        public function attributeLabels()
        {
            return [
                'id'                   => 'ID',
                'username'             => '用户名',
                'passwordConfirm'      => '确认密码',
                'auth_key'             => '令牌',
                'phone'                => '手机号码',
                'password'             => '密码',
                'password_reset_token' => '重置密码的Token',
                'email'                => '邮箱',
                'name'                 => '姓名',
                'avatar'               => '头像',
                'adminGroupId'         => '所属部门',
                'status'               => '状态',
                'created_at'           => '创建时间',
                'created_id'           => '创建用户',
                'updated_at'           => '更新时间',
                'updated_id'           => '修改用户',
                'is_del'               => '是否删除',
                'is_hidden'            => '是否隐藏',
            ];
        }

        public function getToken()
        {
            $time = time();
            $str  = $this->id . ',' . $this->auth_key . ',' . $time;
            return AdminAesEncrypt::aes_encrypt($str);
        }

        public function getGroupPermissions()
        {
            return AdminGroup::getPermissionsById($this->adminGroupId);
        }

        public function getGroupMenus()
        {
            return AdminGroup::getMenuById($this->adminGroupId);
        }

        // 权限验证
        public function can($actionId)
        {
            if ($this->id == 1) {
                return true;
            }
            return AdminGroup::checkUrlInPermissions($actionId, $this->getGroupPermissions());
        }

        /**
         * @param string $clientId
         *
         * @return string
         */
        public function generateAccessToken($clientId = '')
        {

            $adminAccessToken = AdminAccessToken::generateAccessToken($this->id, $clientId);

            return $adminAccessToken->accessToken;
        }

        /**
         * @param string $accessToken
         * @param string $clientId
         * @return array|null|\yii\db\ActiveRecord
         */
        public static function findByAccessToken($accessToken, $clientId = '')
        {
            return static::find()
                ->with(['adminGroup'])
                ->where(
                    [
                        'id' => AdminAccessToken::find()
                            ->where(['clientId' => $clientId, 'accessToken' => $accessToken])
                            ->select('adminId'),
                    ])
                ->one();
        }

        public function logout($clientId, $remoteAddress, $userAgent)
        {
            $adminLog                = $this->createLog();
            $adminLog->type          = '登出后台';
            $adminLog->remoteAddress = $remoteAddress;
            $adminLog->userAgent     = $userAgent;
            $adminLog->method        = 'POST';
            $adminLog->action        = 'Logout';
            $adminLog->status        = AdminLog::STATUS_SUCCESS;
            $adminLog->save(false);

            AdminAccessToken::deleteAccessToken($this->id, $clientId);
        }

        public function createLog()
        {
            $adminLog          = new AdminLog();
            $adminLog->adminId = $this->id;
            return $adminLog;
        }

        public $identity;

        public function fields()
        {
            return [
                'id',
                'name',// 备注名称
                'username',//用户名称
                'avatar'       => function () {
                    if (empty($this->avatar)) {
                        return '/images/avatar.png';
                    }else{
                        return $this->avatar;
                    }
                },
                'phone',
                'identity',
                'adminGroupId' => function () {
                    $ag = AdminGroup::findOneArray(['id' => $this->adminGroupId]);
                    return $ag['name'] ?? '';
                },
                'status',
                'created_at',
                'updated_at',
            ];
        }

        public function generateAuthKey()
        {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        public function getName()
        {
            return $this->name;
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getAdminGroup()
        {
            return $this->hasOne(AdminGroup::class, ['id' => 'adminGroupId']);
        }
    }
