<template>
    <div>
        <TableData :subHeight="240" :search="search" ref="tables"
            @view="openModal({ id: $event.id, isEdit: false }, 'formModal')"
            @edit="openModal({ id: $event.id, isEdit: true }, 'formModal')" 
            @freeze="freeze" url="admin/api/admin/index"
            @changePassword="changePassword" :handle="_handleBtn">
            <template #btn>
                <n-button quaternary @click="openModal({ id: null, isEdit: true }, 'formModal')"
                    v-if="$can('admin/create')">
                    创建</n-button>
            </template>
            <n-input v-model:value="search.phone" filterable placeholder="手机号码" clearable/>
            <n-input v-model:value="search.username" filterable placeholder="用户名" clearable/>
        </TableData>
        <FormModal ref="formModal" />
        <ChangePasswordModal ref="ChangePasswordModal" />
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref, reactive } from "vue";
import TableData from "@/components/common/TableData.vue";
import FormModal from "./components/form.vue";
import ChangePasswordModal from './components/changePassword.vue'

interface AdminModel {
    id: number,
    username: string,
    phone: string,
    email: string,
    name: string,
    password: string,
    passwordConfirm: string,
    avatar: string,
    adminGroupId: number,
    status: number,
    created_at: string,
    updated_at: string,
}

export default defineComponent({
    name: "Admin",
    components: { TableData, FormModal, ChangePasswordModal },
    setup() {
        let search = reactive({
            phone: '',
            username: '',
            adminGroupId: null,
        })

        const model: AdminModel = reactive({} as AdminModel);
        return {
            search,
            model,
        }
    },
    mounted() {
        // setTimeout(() => {
        // if (this.$can('admin/freeze')) {
        const freeze = {
            type: 'warning',
            text: (row: any) => {
                if (row.status == 10) {
                    return '冻结';
                } else {
                    return '解冻';
                }

            },
            emitFunction: "freeze",
        }
        this._handleBtn[0].NButtons.push(freeze);

        // }
        // if (this.$can('admin/change-password')) {
        const changePassword = {
            type: 'error',
            text: '修改密码',
            emitFunction: 'changePassword'
        }
        this._handleBtn[0].NButtons.push(changePassword);
        this._handleBtn[0].width = 280;
        // }
        // }, 800);
    },
    methods: {
        async freeze(row: any) {
            const { data, msg } = await this.$http.post('admin/api/admin/freeze', row);
            if (data) {
                row.status = data;
                window.$message.success(msg)
            }
        },
        changePassword(row: any) {
            this.openModal(row, 'ChangePasswordModal')
        }
    }
})
</script>

<style lang="scss" scoped>

</style>