<?php

    namespace app\common\models\admin;

    use app\common\models\Model;
    use app\modules\backend\api\AdminAesEncrypt;


    /**
     * Class AdminAccessToken
     *
     * @property integer $id
     * @property string  $clientId
     * @property integer $adminId
     * @property string  $accessToken
     * @property string  $remoteAddress
     * @property string  $userAgent
     * @property string  $created_at
     * @property string  $updated_at
     *
     * @package app\core\models\admin
     */
    class AdminAccessToken extends Model
    {
        public $isSaveLog = false;

	    public static function getToken($adminId,$token)
	    {
		    $time = time();
		    $str  = $adminId . ',' . $token . ',' . $time;
		    return AdminAesEncrypt::aes_encrypt($str);
	    }

	    public static function deleteLogin($adminId)
	    {
		    static::deleteAll(['adminId' => $adminId]);
	    }

        public static function deleteAccessToken($adminId, $clientId)
        {
            static::deleteAll(['adminId' => $adminId, 'clientId' => $clientId]);
        }

        public static function generateAccessToken($adminId, $clientId)
        {
            /* @var $adminAccessToken AdminAccessToken|null */
            $adminAccessToken = AdminAccessToken::find()
                ->where(['clientId' => $clientId, 'adminId' => $adminId])
                ->one();

            if ($adminAccessToken == null) {
                $adminAccessToken = new AdminAccessToken();

                $adminAccessToken->adminId    = $adminId;
                $adminAccessToken->clientId   = $clientId;
                $adminAccessToken->created_at = date('Y-m-d H:i:s');
            }

            $randomString = \Yii::$app->getSecurity()->generateRandomString() . '_' . $adminId . '_' . $clientId;

            $accessToken = \Yii::$app->getSecurity()->generatePasswordHash($randomString);


            $adminAccessToken->accessToken   = $accessToken;
            $adminAccessToken->remoteAddress = \Yii::$app->getRequest()->getRemoteIP();
            $adminAccessToken->userAgent     =  \Yii::$app->getRequest()->getUserAgent();
            $adminAccessToken->updated_at    = date('Y-m-d H:i:s');

            $adminAccessToken->save(false);


            return $adminAccessToken;
        }
    }
