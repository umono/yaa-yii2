<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\admin\AdminLog;

    class AdminLogController extends Controller
    {
        public function actionIndex()
        {
            return AdminLog::page()->toTableDataArray();
        }
    }