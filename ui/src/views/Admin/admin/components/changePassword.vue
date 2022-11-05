<template>
    <n-modal v-model:show="isShow" :close-on-esc="false" :mask-closable="false" preset="card" :bordered="true"
        :style="'width:45%'" @close="isShow = false" title="修改密码">
        <div>
            <n-form ref="formRef" :model="model" label-placement="top" label-width="auto"
                require-mark-placement="right-hanging">
                <div class="text-base font-bold">
                    <span class="text-gray-400">修改账号：</span> {{ model.username }}
                </div>
                <n-form-item label="">
                    <n-input type="password" v-model:value="model.password" :input-props="{ autocomplete: 'off' }"
                        placeholder="请输入新密码" />
                </n-form-item>
            </n-form>
        </div>
        <template #footer v-if="$can('admin/change-password')">
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
export default defineComponent({
    setup(props, ctx) {
        return {
            isShow: ref(false),
            loading: ref(false),
            model: ref({
                id: null,
            } as any),
        }
    },
    methods: {
        async show(val: any) {
            this.isShow = true;
            this.model = val;
            // do something...
        },
        async submitFunc() {
            this.loading = true;
            const { data, msg } = await this.$http.post('admin/api/admin/change-password', this.model);
            if (data) {
                window.$message.success(msg);
                this.isShow = false;
            }
            this.loading = false;

        },
    }
})
</script>

<style lang="scss" scoped>

</style>