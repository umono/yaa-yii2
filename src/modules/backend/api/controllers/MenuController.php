<?php

    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\admin\AdminMenu;

    class MenuController extends Controller
    {
        public function actionIndex()
        {
            $get = $this->get;
            $andWhere = [
                ['like', 'name', $get['name'] ?? ''],
            ];
            return AdminMenu::page()->andWhere(['typeName' => 0])->andWhere($andWhere)->toTableDataArray();
        }

        public function actionCreate()
        {
            return AdminMenu::createUpdate($this->param);
        }

        public function actionUpdate()
        {
            return AdminMenu::createUpdate($this->param);
        }

        public function actionView()
        {
            return AdminMenu::viewFind($this->get['id']??-1);
        }
    }