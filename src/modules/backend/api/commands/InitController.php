<?php

    namespace app\modules\backend\api\commands;

    use app\modules\backend\api\models\other\User;
    use Faker\Factory;
    use yii\console\Controller;

    class InitController extends Controller
    {
        public function actionIndex()
        {
            echo "admin commands\n";
        }

        /**
         * 添加用户数据
         * @return void
         * @throws \yii\db\Exception
         */
        public function actionAddUser()
        {
            $faker = Factory::create('zh_CN');

            $num  = range(0, 5000);
            $arr  = [];
            $time = date('Y-m-d H:i:s');
            foreach ($num as $v) {
                $arr[] = [
                    'name'       => $faker->name,
                    'integral'   => $faker->numerify,
                    'phone'      => $faker->phoneNumber,
                    'avatar'     => $faker->imageUrl(480, 480),
                    'gender'     => $faker->boolean,
                    'created_at' => $time,
                    'updated_at' => $time,
                ];
            }
            $columns = ['name', 'integral', 'phone', 'avatar', 'gender', 'created_at', 'updated_at'];

            echo \Yii::$app->db->createCommand()->batchInsert(User::tableName(), $columns, $arr)->execute();
        }
    }