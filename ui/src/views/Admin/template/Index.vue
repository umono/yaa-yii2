<template>
    <TableData :subHeight="240" :search="search" ref="tables"
        @view="openModal({ id: $event.id, isEdit: false }, 'formModal')"
        @edit="openModal({ id: $event.id, isEdit: true }, 'formModal')" 
        :scrollX="1800" url="admin/api/menu/index"
        :handle="_handleBtn">

        <template #btn>
            <n-button quaternary @click="openModal({ id: null }, 'formModal')">创建</n-button>
        </template>

        <n-input v-model:value="search.name" filterable placeholder="模板名称" />

    </TableData>
    <FormModal ref="formModal" />
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue'
import TableData from "@/components/common/TableData.vue";
import FormModal from "./components/form.vue";

export default defineComponent({
    name: "Template",
    components: { TableData, FormModal },

    setup() {
        let search = reactive({
            name: '',
        })
        return {
            search
        }
    },
    methods: {
    }
})
</script>

<style lang="scss" scoped>

</style>