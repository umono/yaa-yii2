<div align="center">
    <div style="font-size:42px;">🤞 Yaa </div> 

 一个基于Vue3、Yii2的干净美观的后台框架，可快速助你CURD开发。
 
<p align="center">
  <a href="http://yaa.speaks.life/">演示</a> •
  <a href="http://yaa.docs.speaks.life/">文档</a>
</p>
</div>


# 示例图
<div style="flex;justify-content: center;">
<img src="https://crustipfs.info/ipfs/QmPhLwQvHijHMCrSvmHoPXcJAPwhrGUgKgmBGRDR8tcD11?filename=1671439195591.jpg" width="30%"/>
<img src="https://crustipfs.live/ipfs/Qme5vqMHFrLAxbQKwz2bRKMBDPNq32izpGymF8U9N8u8Tk?filename=home.jpg" width="30%"/>
<img src="https://crustipfs.live/ipfs/QmQVeyZAuGufD32Pi1st7YnwVxYJD7etX1xoRkvRVoUgyD?filename=1671439128626.jpg" width="30%"/>
<img src="https://crustipfs.info/ipfs/QmQPr81Uxxq9x74kpdqdAy7CWp3eRV2Q73VpGr4v7dUmk5?filename=1671439104910.jpg" width="30%"/>
<img src="https://crustipfs.art/ipfs/QmbMc2ydBWRthviTMNfa5McBhjotDuHgHzpUKdT19kFt6E?filename=1671439154772.jpg" width="30%"/>
</div

# 环境要求

 - PHP >= 7.3
 - Composer >= 2
 - Node.js >= 14

# ✨ 特性

- 🎊 界面清爽、简约
- ⚒️ 原生框架轻度改造、不附带任何臃肿第三方库
- ✨ 自带祝福光环加持，助你效率提升1000X




# 📦  安装

```shell
composer create-project umono/yaa-yii2 

cd yaa-yii2 && php yii init
```


# 🔨 快速上手

呈现数据表格（以用户表）为例：

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

# 🤝 建议

如果您在使用的过程中碰到问题，可以先通过 [issues](https://github.com/umono/yaa-yii2/issues/new) 看看有没有类似的 bug 或者建议。

# License

MIT
