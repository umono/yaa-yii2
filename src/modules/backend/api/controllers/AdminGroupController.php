<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\admin\AdminGroup;
    use app\modules\backend\api\models\admin\AdminMenu;

    class AdminGroupController extends Controller
    {
        public function actionIndex()
        {
            $get = $this->get;
            $andWhere = [
                ['like', 'name', $get['name'] ?? ''],
            ];
            return AdminGroup::page()->andWhere($andWhere)->toTableDataArray();
        }

        public function actionView($id)
        {
            return AdminGroup::byMenuRole($id);
        }

        public function actionCreate()
        {
            return AdminGroup::createUpdate($this->param);
        }

        public function actionUpdate()
        {
            return AdminGroup::createUpdate($this->param);
        }
    }