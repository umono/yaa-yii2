<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\other\User;

    class UserController extends Controller
    {
        public function actionIndex()
        {
            $get      = $this->get;
            $andWhere = [
                ['like', 'nickName', $get['nickName'] ?? ''],
                ['like', 'name', $get['name'] ?? ''],
                ['like', 'phone', $get['phone'] ?? ''],
            ];
            return User::page()->andWhere($andWhere)->toTableDataArray();
        }
    }