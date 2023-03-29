<template>
    <TableData :subHeight="240" :search="search" ref="tables"
        @view="openModal({ id: $event.id, isEdit: false }, 'formModal')"
        @edit="openModal({ id: $event.id, isEdit: true }, 'formModal')" url="admin/api/user/index" @qrCode="qrCode"
        :handle="_handleBtn">
        <template #btn>
            <n-button quaternary @click="openModal({ id: null, isEdit: true }, 'formModal')" v-if="$can('user/create')">
                创建</n-button>
        </template>

        <n-input v-model:value="search.nickName" filterable placeholder="用户昵称" clearable/>
        <n-input v-model:value="search.name" filterable placeholder="姓名" clearable/>
        <n-input v-model:value="search.phone" filterable placeholder="手机号码" clearable/>
    </TableData>
    <FormModal ref="formModal" />
    <n-modal v-model:show="showQrCodeModal">
        <n-card style="width: 600px" class="text-center" title="推广码" :bordered="false" size="huge" role="dialog"
            aria-modal="true">
            <div>{{ qrCodeImg }}</div>
            <n-spin :show="qrCodeImg == ''">
                <n-image width="300" :src="qrCodeImg"></n-image>
            </n-spin>
        </n-card>
    </n-modal>
</template>

<script lang="ts">
import TableData from "@/components/common/TableData.vue";
import FormModal from "./components/form.vue";

export default defineComponent({
    name: "USER",
    components: { TableData, FormModal },

    setup() {
        let search = reactive({
            name: '',
        } as any);

        return {
            search,
            showQrCodeModal: ref(false),
            qrCodeImg: ref('')
        }
    },
    created() {
        const tuiCode = {
            type: 'error',
            text: '推广码',
            emitFunction: 'qrCode'
        }
        this._handleBtn[0].NButtons.push(tuiCode);
        this._handleBtn[0].width = 200;
    },
    methods: {
        async qrCode(row: any) {
            this.qrCodeImg = '';
            this.showQrCodeModal = true;
            const { data } = await (this as any).$http.get('admin/api/user/qrcode', { id: row.id });
            if (data) {
                await 1;
                this.qrCodeImg = data;
            }
        },
    }
})
</script>

<style lang="scss" scoped>

</style>