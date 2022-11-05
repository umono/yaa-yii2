<?php

    namespace app\common\models\admin;



    use app\common\models\Model;

    /**
     * Class AdminGroupPermission
     *
     * @property integer $id
     * @property integer $adminGroupId
     * @property string  $actionId
     * @property string  $des
     *
     * @package app\core\models\admin
     */
    class AdminGroupPermission extends Model
    {
        public static function tableName()
        {
            return '{{%admin_group_permissions}}';
        }

        public static function updatePermissions($adminGroupId, $newPermissions, $oldPermissions)
        {
            $insertPermissions = array_values(array_diff($newPermissions, $oldPermissions));
            $deletePermissions = array_values(array_diff($oldPermissions, $newPermissions));

            if (count($insertPermissions) > 0) {
                $ins = [];

                foreach ($insertPermissions as $permission) {
                    if (empty($permission) || $permission == '0') {
                        continue;
                    }

                    $ins[] = [$adminGroupId, $permission];
                }

                if (!empty($ins)) {
                    AdminGroupPermission::getDb()
                        ->createCommand()
                        ->batchInsert(AdminGroupPermission::tableName(), ['adminGroupId', 'actionId'], $ins)
                        ->execute();
                }
            }

            if (!empty($deletePermissions)) {
                AdminGroupPermission::deleteAll(['adminGroupId' => $adminGroupId, 'actionId' => $deletePermissions]);
            }

            AdminGroup::clearPermissionsCache($adminGroupId);
        }

        public function fields()
        {
            return [
                'actionId',
            ];
        }
    }
