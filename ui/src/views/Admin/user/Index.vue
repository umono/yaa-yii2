<template>
    <TableData :subHeight="240" :search="search" ref="tables"
        @view="openModal({ id: $event.id, isEdit: false }, 'formModal')"
        @edit="openModal({ id: $event.id, isEdit: true }, 'formModal')" 
        url="admin/api/user/index"
        :handle="_handleBtn">

        <n-input v-model:value="search.nickName" filterable placeholder="用户昵称" />
        <n-input v-model:value="search.name" filterable placeholder="姓名" />
        <n-input v-model:value="search.phone" filterable placeholder="手机号码" />
    </TableData>
</template>

<script lang="ts">
import TableData from "@/components/common/TableData.vue";

export default defineComponent({
    name: "USER",
    components: { TableData },

    setup() {
        let search = reactive({
            name: '',
        } as any)
        return {
            search
        }
    },
})
</script>

<style lang="scss" scoped>

</style>