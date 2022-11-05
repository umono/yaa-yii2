<?php

    namespace app\common\models\admin;


    /**
     * This is the model class for table "{{%admin_menu}}".
     *
     * @property int         $id
     * @property string|null $name       菜单名称
     * @property int|null    $typeName   描述0/页面1/功能2
     * @property string|null $typeDes    描述信息
     * @property string|null $actionId   操作权限Url
     * @property int|null    $childrenId 节点
     * @property int|null    $sort       顺序
     * @property string|null $iconName   图标名称
     * @property int|null    $status     0关/1开
     * @property string|null $created_at 创建时间
     * @property string|null $updated_at 更新时间
     */
    class AdminMenu extends \app\common\models\Model
    {
        const TYPE_NAME_PARENT = 0;
        const TYPE_NAME_PAGE = 1;
        const TYPE_NAME_POWER = 2;

        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%admin_menu}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['typeName', 'childrenId', 'sort', 'status'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['name', 'typeDes', 'actionId', 'iconName'], 'string', 'max' => 255],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'name'       => '菜单名称',
                'typeName'   => '描述0/页面1/功能2',
                'typeDes'    => '描述信息',
                'actionId'   => '操作权限Url',
                'childrenId' => '节点',
                'sort'       => '顺序',
                'iconName'   => '图标名称',
                'status'     => '0关/1开',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
            ];
        }

        public static function backMenuAllChildren()
        {
            $menus = AdminMenu::backCacheList(['childrenId' => 0], ['children'], ['orderBy' => ['sort' => SORT_ASC]]);

            $arr = [];
            foreach ($menus as $v) {
                $k     = str_replace("/index", '', $v['actionId']);
                $_menu = [
                    'label'    => $v['name'],
                    'key'      => 'parent_' . $k,
                    'icon'     => $v['iconName'],
                    'children' => $v['children'],
                ];
                if (!empty($_menu['children'])) {
                    foreach ($_menu['children'] as &$child) {
                        $_k    = str_replace("/index", '', $child['actionId']);
                        $child = [
                            'url'     => $child['actionId'],
                            'label'   => $child['name'],
                            'key'     => $_k,
                            'pathKey' => [$_menu['key'], $_k],
                        ];
                    }
                } else {
                    unset($_menu['children']);
                }
                $arr[] = $_menu;
            }
            unset($menus);
            return $arr;
        }

        public function getChild()
        {
            return $this->hasMany(AdminMenu::class, ['childrenId' => 'id']);
        }

        public function getChildren()
        {
            return $this->hasMany(AdminMenu::class, ['childrenId' => 'id']);
        }
    }
