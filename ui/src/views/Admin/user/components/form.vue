<template>
    <n-drawer v-model:show="isShow" width="48%" placement="right" :auto-focus="false">
        <n-drawer-content title="推广员">
            <n-spin :show="loading">
                <n-card :bordered="false">
                    <n-form>
                        <n-form-item label="">
                            <div>
                                <UploadPhoto :src="model.avatar" @upSuccess="upPhoto" />
                            </div>
                        </n-form-item>
                        <n-form-item label="用户姓名">
                            <n-input v-model:value="model.name" @keydown.enter.prevent />
                        </n-form-item>
                        <n-form-item label="手机号码">
                            <n-input v-model:value="model.phone" @keydown.enter.prevent />
                        </n-form-item>
                        <n-form-item label="证书编号">
                            <n-input v-model:value="model.certificateNo" @keydown.enter.prevent />
                        </n-form-item>
                        <n-form-item label="密码" v-if="isEdit">
                            <n-input v-model:value="model.password" @keydown.enter.prevent />
                        </n-form-item>
                        <n-form-item label="等级">
                            <n-select v-model:value="model.level" :options="levelGroup" label-field="name"
                                value-field="id"></n-select>
                        </n-form-item>
                    </n-form>

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
import UploadPhoto from "@/components/common/uploads/CoverPhoto.vue";
export default defineComponent({
    components: { UploadPhoto },
    setup() {
        const reload: any = inject("reload")
        return {
            isShow: ref(false),
            isEdit: ref(false),
            loading: ref(false),
            model: ref({
                id: null,
                name: '',
                avatar: '',
                phone: '',
                certificateNo: '',
                level: '',
            } as any),
            reload,
            levelGroup: ref([])
        }
    },
    methods: {
        async show(val: any) {
            this.isShow = true;
            this.model.id = val.id;
            this.isEdit = val.isEdit;
            this.loading = true;
            // do something...
            const { data } = await this.$http.get('admin/api/user/view?id=' + val.id);
            if (data) {
                if(val.id){
                    this.model = data.view;
                }else{
                    this.model = {}
                }
                this.levelGroup = data.levelGroup;
            } else {
                this.model = {};
            }
            this.loading = false;
        },
        async submitFunc() {
            this.loading = true;

            const { data, msg } = await this.$http.post('admin/api/user/update', this.model);
            if (data) {
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

<style lang="scss" scoped></style>