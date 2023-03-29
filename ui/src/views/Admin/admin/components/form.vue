<template>
    <n-modal v-model:show="isShow" :close-on-esc="false" :mask-closable="false" preset="card" :bordered="true"
        :style="'width:45%'" @close="isShow = false" title="员工信息">
        <div class="custom-card" style="margin-top:-30px">
            <n-spin :show="loading">
                <n-form ref="formRef" :model="model" label-placement="top" label-width="auto"
                    require-mark-placement="right-hanging">

                    <div class="flex mb-8">
                        <div class="w-1/2">
                            <UploadPhoto class="mb-2 mt-8" :src="model.avatar" @upSuccess="upPhoto" />
                        </div>
                        <div class="w-1/2">
                            <div class="text-gray-400 my-1">电话号码</div>
                            <n-input v-model:value="model.phone" placeholder="请输入电话号码" />
                            <div class="text-gray-400 my-1">姓名</div>
                            <n-input v-model:value="model.name" placeholder="请输入姓名" />
                            <div class="text-gray-400 my-1">用户昵称</div>
                            <n-input v-model:value="model.username" placeholder="请输入用户名称" />
                            <div class="text-gray-400 my-1">邮箱</div>
                            <n-input v-model:value="model.email" placeholder="请输入邮箱" />
                        </div>
                    </div>
                    <n-form-item label="密码" v-if="!model.id">
                        <n-input type="password" v-model:value="model.password" :input-props="{ autocomplete: 'off' }"
                            placeholder="请输入密码" />
                    </n-form-item>
                    <n-form-item label="重复密码" v-if="!model.id">
                        <n-input v-model:value="model.passwordConfirm" :input-props="{ autocomplete: 'off' }"
                            type="password" placeholder="请重复输入密码" />
                    </n-form-item>
                    <n-form-item label="所属部门">
                        <n-radio-group v-model:value="model.adminGroupId" name="radiogroup">
                            <n-space>
                                <n-radio v-for="(item, index) in groups" :key="'ra-group-' + index" :value="item.id">
                                    {{ item.name }}
                                </n-radio>
                            </n-space>
                        </n-radio-group>
                    </n-form-item>
                </n-form>
            </n-spin>
        </div>
        <template #footer v-if="isEdit">
            <slot name="footer">
                <n-space>
                    <n-button @click="isShow = false" strong secondary>取消</n-button>
                    <n-button strong secondary type="primary" @click="submitFunc" :loading="loading">保存</n-button>
                </n-space>
            </slot>
        </template>
    </n-modal>
</template>

<script lang="ts">
import UploadPhoto from "@/components/common/uploads/CoverPhoto.vue";
export default defineComponent({
    components: { UploadPhoto },
    setup(props, ctx) {
        const reload: any = inject("reload")
        return {
            isShow: ref(false),
            isEdit: ref(false),
            loading: ref(false),
            model: ref({
                id: null,
            } as any),
            reload,
            groups: ref([] as any),
        }
    },
    methods: {
        async show(val: any) {
            this.isShow = true;
            this.model.id = val.id;
            this.isEdit = val.isEdit;
            this.loading = true;
            // do something...
            const { data } = await this.$http.get('admin/api/admin/view?id=' + val.id);
            if (data) {
                if (val.id) {
                    this.model = data.admin;
                } else {
                    this.model = {};
                }
                this.groups = data.groups;
            }
            this.loading = false;

        },
        async submitFunc() {
            this.loading = true;
            const { data, msg } = await this.$http.post('admin/api/admin/update', this.model);
            if (data) {
                // 
                const userInfo = this.$store.getters['auth/getUser'];
                const newUserInfo = JSON.parse(JSON.stringify(userInfo));
                if (newUserInfo.id == this.model.id) {
                    newUserInfo.avatar = this.model.avatar;
                    newUserInfo.name = this.model.name;
                    newUserInfo.username = this.model.username;
                    this.$store.dispatch('auth/updateUser', newUserInfo);
                }
                window.$message.success(msg);
                this.isShow = false;
                this.reload();
            }
            this.loading = false;

        },
        upPhoto(e: string) {
            this.model.avatar = e;
        }
    }
})
</script>

<style lang="scss" scoped>

</style>