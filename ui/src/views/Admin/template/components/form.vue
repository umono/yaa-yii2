<template>
    <n-drawer v-model:show="isShow" width="48%" placement="right" :auto-focus="false">
        <n-drawer-content title="Hi,Template">
            <n-spin :show="loading">
                <n-card :bordered="false">
                    <div>
                        //do something
                    </div>

                    <template #footer v-if="isEdit">
                        <n-space justify="end">
                            <n-button type="default" @click="isShow = false" strong secondary>取消</n-button>
                            <n-button type="primary" @click="submitFunc" :loading="loading">保存</n-button>
                        </n-space>
                    </template>
                </n-card>
            </n-spin>
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
                id: null,
                name: '',
            } as any),
            reload
        }
    },
    methods: {
        async show(val: any) {
            this.isShow = true;
            this.model.id = val.id;
            this.isEdit = val.isEdit;
            this.loading = true;
            // do something...
            if (val.id) {
                const { data } = await this.$http.get('admin/api/template/view?id=' + val.id);
                if (data) {
                    this.model = data;
                } else {
                    this.model = {};
                }
            } else {
                this.model = {};
            }
            this.loading = false;
        },
        async submitFunc() {
            this.loading = true;

            const { data, msg } = await this.$http.post('admin/api/template/update', this.model);
            if (data) {
                window.$message.success(msg);
                this.isShow = false;
                this.reload();
            }
            this.loading = false;

        },
    }
})
</script>

<style lang="scss" scoped>

</style>