<template>
    <n-drawer v-model:show="isShow" width="58%" placement="right" :auto-focus="false">
        <n-drawer-content>
            <n-card :bordered="false">
                    <n-card title="菜单" class="">
                        <n-space>
                            <div>
                                <span class="text-stone-400">菜单名称</span>
                                <n-input v-model:value="model.name" placeholder="菜单" />
                            </div>
                            <div>
                                <span class="text-stone-400">名称key</span>
                                <n-input v-model:value="model.actionId" placeholder="menu" />
                            </div>
                            <div>
                                <span class="text-stone-400">图标名称</span>
                                <n-input v-model:value="model.iconName" placeholder="Home" />
                                <div class="text-stone-400 p-3 pl-0">
                                    查阅：<a href="https://www.xicons.org/#/" target="_blank" class="ext-stone-400">xicons</a>
                                </div>
                            </div>
                            <div>
                                <span class="text-stone-400">显示顺序</span>
                                <n-input v-model:value="model.sort" placeholder="1" />
                            </div>
                        </n-space>
                    </n-card>

                    <n-card title="添加子菜单" class="mt-8">
                        <n-tabs type="card" addable @add="addMenu" :closable="true" @close="deleteMenuClose"
                            class="card-tabs">
                            <n-tab-pane v-for="(item, index) in model.child" :name="item.name" :tab="item.name">
                                <p>⚒️</p>
                                <div>
                                    <n-space>
                                        <div>
                                            <span class="text-stone-400">菜单名称</span>
                                            <n-input v-model:value="item.name"></n-input>
                                        </div>
                                        <div>
                                            <span class="text-stone-400">描述</span>
                                            <n-input v-model:value="item.typeDes"></n-input>
                                        </div>
                                        <div>
                                            <span class="text-stone-400">菜单URL</span>
                                            <n-input v-model:value="item.actionId"></n-input>
                                        </div>
                                    </n-space>
                                </div>

                                <p>⛏️ <n-button strong tertiary type="success" size="small" @click="item.child.push({})">
                                        添加权限</n-button>
                                </p>
                                <n-table :single-line="false">
                                    <thead>
                                        <tr class="text-stone-400">
                                            <th>权限名称</th>
                                            <th>描述</th>
                                            <th>权限URL</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(_item, _index) in item.child" :key="_index + '_power_child'">
                                            <td>
                                                <n-input v-model:value="_item.name" placeholder="模板创建"></n-input>
                                            </td>
                                            <td>
                                                <n-input v-model:value="_item.typeDes" placeholder="模板创建权限，可以访问url数据">
                                                </n-input>
                                            </td>
                                            <td>
                                                <n-input v-model:value="_item.actionId" placeholder="template/delete">
                                                </n-input>
                                            </td>
                                            <td>
                                                <n-button strong tertiary type="error" size="tiny"
                                                    @click="deletePowerMenu(_index, index)">
                                                    删除
                                                </n-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </n-table>
                            </n-tab-pane>
                        </n-tabs>
                    </n-card>

                <n-space class="mt-8" justify="end" v-if="isEdit">
                    <n-button type="default" @click="isShow = false" strong secondary>取消</n-button>
                    <n-button type="primary" @click="submitFunc" :loading="loading">保存</n-button>
                </n-space>
            </n-card>
        </n-drawer-content>
    </n-drawer>
</template>
  
<script lang="ts">
export default defineComponent({
    setup() {
        const reload: any = inject("reload")
        return {
            isShow: ref(false),
            isEdit: ref(false),
            loading: ref(false),
            model: ref({
                child: []
            } as any),
            reload,
            deleteMenuIds: [] as any,
            deletePowerIds: [] as any,

        }
    },
    methods: {
        async show(val: any) {
            this.isShow = true;
            this.isEdit = val.isEdit;
            if (val.id) {
                this.model.id = val.id;
                // do something...
                const { data } = await this.$http.get('admin/api/menu/view?id=' + val.id);
                if (data) {
                    this.model = data;
                }
            } else {
                this.model = { child: [] };
            }

        },
        async submitFunc() {
            this.loading = true;
            const param = {
                ...this.model,
                deleteMenuIds: this.deleteMenuIds,
                deletePowerIds: this.deletePowerIds
            }
            const { data, msg } = await this.$http.post('admin/api/menu/update', param);
            if (data) {
                window.$message.success(msg);
                this.isShow = false;
                this.reload();
                await this.$store.dispatch('auth/authentication');
            }
            this.loading = false;
        },
        addMenu() {
            const arr = {
                name: '未命名菜单' + (this.model.child.length + 1),
                child: []
            }
            this.model.child.push(arr)
        },
        deleteMenuClose(name: any) {
            const nameIndex = this.model.child.findIndex((item: any) => item.name === name)
            if (!~nameIndex) return

            console.log(~this.model.child[nameIndex].id)
            if (~this.model.child[nameIndex].id) this.deleteMenuIds.push(this.model.child[nameIndex].id)
            this.model.child.splice(nameIndex, 1);
        },
        deletePowerMenu(_index: number, index: number) {

            if (~this.model.child[index].child[_index].id) this.deletePowerIds.push(this.model.child[index].child[_index].id);

            this.model.child[index].child.splice(_index, 1);

        }
    }
})
</script>

<style lang="scss" scoped>

</style>