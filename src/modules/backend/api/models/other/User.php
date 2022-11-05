<?php

    namespace app\modules\backend\api\models\other;

    class User extends \app\common\models\other\User
    {

        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'nickName'   => '用户昵称',
                'name'       => '用户姓名',
                //'_hash'      => 'HASH地址',
                'openId'     => '微信openId',
                'phone'      => '手机号码',
                'integral'   => '积分数据',
                'password'   => '密码',
                'avatar'     => '头像',
                'status'     => '账号状态',
                'auth_key'   => '权限token，登录TOKEN',
                'gender'     => '性别:1男2女',
                'is_del'     => '是否删除',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
            ];
        }

        public static function transFormatData($item, bool $info = false, array $options = [])
        {
            $item['gender'] = $item['gender'] == 1 ? '男' : '女';
            return $item;
        }
    }