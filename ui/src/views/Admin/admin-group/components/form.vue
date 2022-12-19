<template>
    <n-drawer v-model:show="isShow" width="68%" placement="right" :auto-focus="false">
        <n-drawer-content title="">
            <n-card :bordered="false">
                <n-form label-width="auto">
                    <n-form-item label="名称" show-require-mark class="w-1/3">
                        <n-input v-model:value="model.name" placeholder="请输入部门名称" />
                    </n-form-item>
                    <n-form-item label="权限" show-require-mark>
                        <n-card>
                            <n-collapse arrow-placement="right" class="menu-rule-auth-box">
                                <n-collapse-item :name="'menu_' + i" v-for="(item, i) in menuRole" :key="'menu_' + i">
                                    <template #header>
                                        <n-button quaternary class="m-btn" @click.stop>
                                            <n-checkbox @update:checked="updateAllSelect($event, i)"
                                                v-model:checked="item.selectAll">
                                            </n-checkbox>

                                            <div class="label">
                                                {{ item.name }}
                                                <span
                                                    :class="item.sumRole != 0 && item.own == item.sumRole ? 'bg-green-500 text-white' : 'bg-stone-100'">
                                                    {{ item.own }}/{{ item.sumRole }}
                                                </span>
                                            </div>

                                        </n-button>
                                    </template>

                                    <n-grid cols="2 m:3 l:4" x-gap="12" :y-gap="12" responsive="screen">
                                        <n-grid-item v-for="(_page, _i) in item.child" :key="'page_' + _i">
                                            <n-card>
                                                <div class="text-sm text-stone-400 mb-1">菜单</div>
                                                <n-checkbox class="text-base font-bold" v-model:checked="_page.checked"
                                                    @update:checked="upArrSelect">
                                                    {{ _page.name }}</n-checkbox>
                                                <div class="text-sm text-stone-400 mt-2">权限</div>
                                                <div class="flex h-10 items-center font-bold"
                                                    v-for="(child, i) in _page.child">
                                                    <n-checkbox v-model:checked="child.checked"
                                                        @update:checked="upArrSelect">
                                                        {{ child.name }}
                                                    </n-checkbox>
                                                    <n-tooltip trigger="click">
                                                        <template #trigger>
                                                            <n-button quaternary circle class="text-xl">
                                                                <n-icon>
                                                                    <Info16Regular />
                                                                </n-icon>
                                                            </n-button>
                                                        </template>
                                                        {{ child.typeDes }}
                                                    </n-tooltip>
                                                </div>
                                            </n-card>
                                        </n-grid-item>
                                    </n-grid>
                                </n-collapse-item>
                            </n-collapse>
                        </n-card>
                    </n-form-item>
                </n-form>

                <template #footer v-if="isEdit">
                    <n-space justify="end">
                        <n-button type="default" @click="isShow = false" strong secondary>取消</n-button>
                        <n-button type="primary" @click="submitFunc" :loading="loading">保存</n-button>
                    </n-space>
                </template>
            </n-card>

        </n-drawer-content>
    </n-drawer>
</template>
  
<script lang="ts">
import type { DrawerPlacement } from 'naive-ui'
import { Info16Regular } from '@vicons/fluent'

interface MenuChildType {
    name: string,
    actionId: string,
    checked: boolean,
    child: [{
        name: string,
        typeDes: string,
        actionId: string,
        checked: boolean
    }]
}
interface MenuRoleType {
    name: string,
    sumRole: number,
    own: number,
    selectAll: boolean,
    child: [MenuChildType]
}

export default defineComponent({
    components: { Info16Regular },
    setup() {
        const menuRole = ref([] as MenuRoleType[]);
        const upArrSelect = () => {
            menuRole.value.forEach((element) => {
                let allTrueSum = 0;
                element.child.forEach(_child => {
                    if (_child.checked) {
                        allTrueSum += 1;
                    }
                    if (_child.child) {
                        _child.child.forEach(element => {
                            if (element.checked) {
                                allTrueSum += 1;
                            }
                        });
                    }
                });
                element.own = allTrueSum;
                if (element.sumRole == allTrueSum) {
                    element.selectAll = true;
                } else {
                    element.selectAll = false;
                }
            });
        }
        const reload: any = inject("reload")
        return {
            isShow: ref(false),
            isEdit: ref(false),
            loading: ref(false),
            menuRole,
            upArrSelect,
            model: ref({
                id: null,
                name: '',
            }),
            reload
        }
    },
    methods: {
        async show(val: any) {
            this.isShow = true;
            this.isEdit = val.isEdit;
            this.model.id = val.id;

            const { data } = await this.$http.get('admin/api/admin-group/view?id=' + val.id);
            if (data) {
                this.menuRole = data.menuRole;
                this.model.name = data.name
            }
        },
        async submitFunc() {
            this.loading = true;

            const param = {
                ...this.model,
                data: this.menuRole
            }
            const { data, msg } = await this.$http.post('admin/api/admin-group/update', param);
            if (data) {
                window.$message.success(msg);
                this.isShow = false;
                this.reload();
                await this.$store.dispatch('auth/authentication');
            }
            this.loading = false;

        },
        updateAllSelect(e: any, i: any) {
            const selectArr = this.menuRole[i];

            selectArr.selectAll = e;
            if (e) {
                selectArr.own = selectArr.sumRole;
            } else {
                selectArr.own = 0;
            }
            selectArr.child.forEach(element => {
                element.checked = e;
                if (element.child && element.child.length > 0) {
                    element.child.forEach(_child => {
                        _child.checked = e;
                    });
                }
            });
        },
    }
})
</script>

<style lang="scss" scoped>
.menu-rule-auth-box {
    :deep(.n-collapse-item__header-main) {
        align-items: center !important;
        justify-content: space-between !important;
    }

    .m-btn {
        box-shadow: $boxShadowBtn;
        border-radius: 9999px;
        font-weight: 700 !important;
        letter-spacing: 0;
        height: 40px;

        .label {
            margin-left: 8px;

            span {
                padding: 0 8px;
                font-size: 10px;
                border-radius: 99999px;
            }
        }
    }
}
</style>