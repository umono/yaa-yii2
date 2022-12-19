<?php

    namespace app\modules\backend\api\models\admin;

    use app\common\models\admin\Admin;
    use app\common\models\admin\Identity;
    use Gregwar\Captcha\CaptchaBuilder;
    use umono\multiple\helpers\StringHelper;
    use yii\base\InvalidArgumentException;

    /**
     * Login form
     */
    class LoginForm extends \yii\base\Model
    {
        const ACCOUNT_TYPE_EMAIL = 'EMAIL';
        const ACCOUNT_TYPE_PHONE = 'PHONE';
        public $clientId;
        public $userAgent;
        public $remoteAddress;
        public $account;
        public $password;
        public $captchaEnabled = true; // 是否开启验证码
        public $captchaCode;
        public $captchaRetryNumber = 2; // x次后显示验证码图片
        public $captchaRetryLimitNumber = 6; // x次后提示超时不予登录验证，超时结束后重试
        public $accountInvalidTypeMessage = '无效的帐号,帐号应该是邮箱地址或者手机号码';
        public $accountNotExistMessage = '账号不存在';
        public $passwordErrorMessage = '密码输入错误';
        /* @var $accessToken string */
        public $accessToken = '';
        protected $accountType = false;
        /* @var $identity Identity */
        private $identity = null;

        public function init()
        {
            parent::init();

            if (empty($this->clientId)) {
                throw new InvalidArgumentException('初始化时请设置 clientId 属性');
            }
        }

        public function rules()
        {
            return [
                [['account', 'password'], 'trim'],
                [['account', 'password'], 'required'],
                [['account', 'password', 'captchaCode'], 'string'],
                ['account', 'validateAccount'],
                ['password', 'validatePassword'],
            ];
        }

        public function attributeLabels()
        {
            return [
                'account'  => '账号',
                'password' => '密码',
                'captcha'  => '验证码',
            ];
        }

        public $haveErr = false;
        public $errMsg = '';

        public function msgErr($msg)
        {
            if (!$this->haveErr) {
                $this->haveErr = true;
                $this->errMsg  = $msg;

                $retryKey   = substr(md5($this->clientId . '-' . $this->remoteAddress), 0, 8);
                $retryTimes = $this->getLoginRetryTimes($retryKey);
                // 错误超过次，x限制次数分钟一次,每次多加5分钟
                if ($retryTimes >= $this->captchaRetryLimitNumber) {
                    $this->setLoginRetryTimes($retryKey, $retryTimes + 1, (60 * 5 * $retryTimes));
                } else {
                    $this->setLoginRetryTimes($retryKey, $retryTimes + 1);
                }
            }
        }

        public function login()
        {
            $this->validateAccount($this->account);

            $this->validatePassword($this->password);

            $arr            = $this->loginValidateCaptcha();
            $arr['haveErr'] = $this->haveErr;

            if (!$this->haveErr) {

                $this->accessToken = $this->identity->generateAccessToken($this->clientId);

                if ($this->identity->status == Admin::STATUS_FREEZE) {
                    $this->msgErr('该账号被冻结');
                }

                \Yii::$app->getUser()->login($this->identity);

                $arr['userInfo']          = $this->identity->toArray();
                $arr['userInfo']['token'] = $this->identity->getToken();

                $this->deleteLoginRetryTimes($this->retryKey);
            } else {
                $arr['errMsg'] = $this->errMsg;
            }
            return $arr;
        }

        private function validateAccount($account)
        {
            if (StringHelper::isEmail($account)) {
                $this->account  = static::ACCOUNT_TYPE_EMAIL;
                $this->identity = Admin::findOne(['email' => $account]);
            }

            if (StringHelper::isPhoneNumber($account) || $account == $_ENV['SUPER_ADMIN_ACCOUNT']) {
                $this->accountType = static::ACCOUNT_TYPE_PHONE;
                $this->identity    = Admin::findOne(['phone' => $account]);
            }
            if (!$this->accountType) {
                $this->msgErr($this->accountInvalidTypeMessage);
            }
            if (!$this->identity) {
                $this->msgErr($this->accountNotExistMessage);
            }
        }

        private function validatePassword($password)
        {
            if (!$this->identity || !$this->identity->validatePassword($password)) {

                $this->msgErr($this->passwordErrorMessage);
            }
        }

        // 判断登录时的次数以及验证码问题验
        protected $retryKey;

        private function loginValidateCaptcha()
        {
            $retryKey       = substr(md5($this->clientId . '-' . $this->remoteAddress), 0, 8);
            $this->retryKey = $retryKey;
            $retryTimes     = $this->getLoginRetryTimes($retryKey);
            $this->limitValidate();
            if ($retryTimes >= $this->captchaRetryNumber) {
                // 是否有验证码
                $captchaArr = $this->getCaptchaArr($retryKey);

                if ($this->captchaCode && !empty($captchaArr['code'] ?? '')) {
                    if (mb_strtoupper($this->captchaCode) != mb_strtoupper($captchaArr['code'])) {
                        $this->msgErr('验证码无效:(');
                    }
                }else{
                    $this->msgErr('请输入验证码:(');
                }
                $captcha = new CaptchaBuilder;
                $captcha->build();
                $captchaImgArr = [
                    'img'  => $captcha->inline(),
                    'code' => $captcha->getPhrase(),
                ];
                unset($captcha);
                $this->setCaptchaArr($retryKey, $captchaImgArr);
            }

            return [
                'retryNumber' => $retryTimes,
                'captchaImg'  => $captchaImgArr['img'] ?? '',
            ];
        }

        public function limitValidate()
        {
            $retryKey   = substr(md5($this->clientId . '-' . $this->remoteAddress), 0, 8);
            $retryTimes = $this->getLoginRetryTimes($retryKey);
            if ($retryTimes >= $this->captchaRetryLimitNumber) {
                Admin::error('请等待' . 5 * $retryTimes . '分钟后重试！');
            }
        }

        protected function getLoginRetryCachePrefix(): string
        {
            return 'YAA-ADMIN';
        }

        private function getLoginRetryTimes($key)
        {
            $loginRetryTimes = \Yii::$app->getCache()->get($this->getLoginRetryCachePrefix() . '-' . $key);

            if ($loginRetryTimes == false) {
                $loginRetryTimes = 0;
            }

            return $loginRetryTimes;
        }

        private function setLoginRetryTimes($key, $times, $_time = null)
        {
            \Yii::$app->getCache()->set($this->getLoginRetryCachePrefix() . '-' . $key, $times, null);
        }

        private function deleteLoginRetryTimes($key)
        {
            \Yii::$app->getCache()->delete($this->getLoginRetryCachePrefix() . '-' . $key);
        }

        private function setCaptchaArr($key, $arr)
        {
            \Yii::$app->getCache()->set(
                $this->getLoginRetryCachePrefix() . '-' . $key . '-' . 'captcha', $arr, 60 * 30);
        }

        private function getCaptchaArr($key)
        {
            return \Yii::$app->getCache()->get($this->getLoginRetryCachePrefix() . '-' . $key . '-' . 'captcha');
        }
    }