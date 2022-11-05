<?php

    namespace app\common\models\admin;

    use app\common\models\Model;


    /**
     * Class AdminGroup
     *
     * @property integer $id
     * @property string  $name
     *
     * @package app\core\models\admin
     */
    class AdminGroup extends Model
    {
        public $isSaveLog = false;
        public const PERMISSIONS_CACHE_PREFIX = 'ADMIN_GROUP_PERMISSIONS_';
        public $permissions;

        public static function tableName()
        {
            return '{{%admin_group}}';
        }

        public function attributeLabels()
        {
            return [
                'id'   => 'ID',
                'name' => '部门名称',
            ];
        }

        public function rules()
        {
            return [
                [
                    [
                        'name',
                        'permissions',
                    ],
                    'trim',
                ],
                [
                    'name',
                    'required',
                ],
                [
                    'name',
                    'string',
                    'length' => [
                        3,
                        20,
                    ],
                ],
                [
                    'name',
                    'unique',
                ],
            ];
        }

        public function fields()
        {
            return [
                'id',
                'name',
            ];
        }

        public function extraFields()
        {
            return [
                'permissions' => function () {
                    return AdminGroup::getPermissionsById($this->id);
                },
            ];
        }

        public static function getMenuById($id)
        {
            function getMenu($menu, $permissions)
            {
                if (isset($menu['url']) && !AdminGroup::checkUrlInPermissions(
                        $menu['url'], $permissions)
                    //&& (!isset($menu['status']) || !$menu['status'])
                ) {
                    return false;
                }

                $children = false;

                if (isset($menu['children'])) {
                    $children = [];

                    foreach ($menu['children'] as $child) {
                        $item = getMenu($child, $permissions);

                        if ($item !== false) {
                            $children[] = $item;
                        }
                    }

                    if (empty($children)) {
                        return false;
                    }
                }

                $result = [];

                foreach ($menu as $key => $value) {
                    if ($key != 'children') {
                        $result[$key] = $value;
                    }
                }

                if ($children !== false) {
                    $result['children'] = $children;
                }

                return $result;
            }

            $allMenus         = AdminMenu::backMenuAllChildren();
            $groupPermissions = AdminGroup::getPermissionsById($id);

            $menus = [];

            foreach ($allMenus as $menu) {
                $item = getMenu($menu, $groupPermissions);

                if ($item !== false) {
                    $menus[] = $item;
                }
            }

            return $menus;
        }

        public static function checkUrlInPermissions($url, $permissions)
        {
            if (empty($url)) {
                return false;
            }

            return in_array($url, $permissions);
        }

        // 从部门ID获取该部门的全新列表
        public static function getPermissionsById($groupId)
        {
            $cacheKey = static::PERMISSIONS_CACHE_PREFIX . $groupId;

            $acl = \Yii::$app->getCache()->get($cacheKey);

            if ($acl !== false) {
                return $acl;
            }

            $acl = AdminGroupPermission::find()
                ->where(['adminGroupId' => $groupId])
                ->select('actionId')->column();
            \Yii::$app->getCache()->set($cacheKey, $acl);

            return $acl;
        }

        public static function clearPermissionsCache($groupId)
        {
            \Yii::$app->getCache()->delete(static::PERMISSIONS_CACHE_PREFIX . $groupId);
        }

        public function afterDelete()
        {
            parent::afterDelete();

            AdminGroupPermission::deleteAll(['adminGroupId' => $this->id]);
        }

        public function afterSave($insert, $changedAttributes)
        {
            if (is_array($this->permissions)) {
                AdminGroupPermission::updatePermissions(
                    $this->id, $this->permissions, $insert
                    ? [] : AdminGroup::getPermissionsById($this->id));
            }

            parent::afterSave($insert, $changedAttributes);
        }

        public function beforeDelete(): bool
        {
            if (Admin::find()->where(['adminGroupId' => $this->id])->exists()) {
                $this->addError('id', '部门内还有员工，无法删除');

                return false;
            }

            return parent::beforeDelete();
        }
    }
