# yaa-yii2
 一个基于Vue3、Yii2的后台框架，可快速助你CURD开发。

## 环境要求

 - PHP >= 7.3
 - Composer >= 2
 - Node.js >= 14


## 安装

```shell
composer create-project umono/yaa-yii2 

cd yaa-yii2 && php yii init
```


## 使用示例

基本使用，呈现数据表格（以用户表）为例：

### vue 文件
```vue
<template>
    <TableData :subHeight="240" :search="search" ref="tables"
        @view="openModal({ id: $event.id, isEdit: false }, 'formModal')"
        @edit="openModal({ id: $event.id, isEdit: true }, 'formModal')" 
        url="admin/api/user/index"
        :handle="_handleBtn">
        <!-- 搜索条件开始 -->
        <n-input v-model:value="search.nickName" filterable placeholder="用户昵称" />
        <n-input v-model:value="search.name" filterable placeholder="姓名" />
        <n-input v-model:value="search.phone" filterable placeholder="手机号码" />
        <!-- 搜索条件结束 -->
    </TableData>
</template>

<script lang="ts">
import TableData from "@/components/common/TableData.vue";

export default defineComponent({
    name: "USER",
    components: { TableData },

    setup() {
        // 搜索条件参数
        // 在开发中尽量使用search参数包含所有条件
        let search = reactive({
            name: '',
        } as any)
        return {
            search
        }
    },
})
</script>
```


### php 文件
```php
<?php
    namespace app\modules\backend\api\controllers;

    use app\modules\backend\api\Controller;
    use app\modules\backend\api\models\other\User;

    class UserController extends Controller
    {
        // 数据列表
        public function actionIndex()
        {
            $get      = $this->get;
            $andWhere = [
                ['like', 'nickName', $get['nickName'] ?? ''],
                ['like', 'name', $get['name'] ?? ''],
                ['like', 'phone', $get['phone'] ?? ''],
            ];
            return User::page()->andWhere($andWhere)->toTableDataArray();
        }

        // 创建、修改、删除
        // ...
    }
```

效果图如下：

![用户表界面](https://crustipfs.art/ipfs/QmYZwtxKxx72cWGhWVkYsAojjgw1xGpJbsQqmr6iNh2pva?filename=1671367264971.jpg)


## 文档

