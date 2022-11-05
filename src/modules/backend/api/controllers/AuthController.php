<?php

    namespace app\modules\backend\api\controllers;

    use app\common\models\admin\AdminAccessToken;
    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\admin\AdminMenu;
    use app\modules\backend\api\models\admin\LoginForm;
    use Gregwar\Captcha\CaptchaBuilder;

    /**
     * 后台验证入口
     */
    class AuthController extends Controller
    {
        public function actionLogin()
        {
            $login = new LoginForm(['clientId' => $this->getClientId()]);
            $login->limitValidate();
            $login->load($this->param, '');
            return $login->login();
        }

        // 获取菜单与路由权限
        public function actionAuthentication()
        {
            $menus = $this->getIdentity()->getGroupMenus();
            $arr   = AdminMenu::handlerMenuBack($menus);
            return [
                'groupMenus'   => $menus,
                'groupMenuKey' => $arr,
                'groupAcl'     => $this->getIdentity()->getGroupPermissions(),
            ];
        }

        public function actionLogout()
        {
            $this->getIdentity()->logout(
                $this->getClientId(),
                \Yii::$app->getRequest()->getRemoteIP(),
                \Yii::$app->getRequest()->getUserAgent()
            );
            \Yii::$app->getUser()->logout();

            AdminAccessToken::deleteLogin(\Yii::$app->user->id);

            return $this->success('退出登陆成功');
        }

        public function verbs()
        {
            return [
                'login'          => ['POST'],
                'authentication' => ['GET'],
                'logout'         => ['POST'],
            ];
        }
    }