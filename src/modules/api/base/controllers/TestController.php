<?php
    /**
     * Created by PhpStorm
     * USER umono
     * Date 2021/9/8 2:29 下午
     */

    namespace app\modules\api\base\controllers;


    use app\modules\api\base\Controller;


    class TestController extends Controller
    {
        /**
         * @OA\Get(
         *     path="/test",
         *     tags={"测试接口"},
         *     summary="这是一个测试接口",
         *     description="返回当前时间",
         *     @OA\Response(
         *         response=400,
         *         description="Invalid status value"
         *     ),
         * )
         */
        public function actionIndex(): string
        {
            return 'hey, this is base Api.' . date('Y-m-d H:i:s');
        }
    }