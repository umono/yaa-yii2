<?php

    namespace app\common\models;

    use umono\multiple\model\ActiveRecordModel;
    use yii\behaviors\TimestampBehavior;

    abstract class Model extends ActiveRecordModel
    {
        public function behaviors()
        {
            return [
                [
                    'class' => TimestampBehavior::class,
                    'value' => function ($event) {
                        return date('Y-m-d H:i:s');
                    },
                ],
            ];
        }

        public static function findOneArray($condition): array
        {
            $model = static::findOne($condition);
            if ($model) {
                return $model->toArray();
            } else {
                return [];
            }
        }
    }