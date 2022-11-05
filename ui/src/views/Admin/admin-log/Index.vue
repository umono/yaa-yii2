<template>
    <TableData :subHeight="240" :search="search" ref="tables" @view="refresh" :scrollX="1800"
        url="admin/api/admin-log/index" :handle="_handleBtn">
    </TableData>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue'
import TableData from "@/components/common/TableData.vue";
export default defineComponent({
    name: "AdminLog",
    components: { TableData },

    setup() {
        let search = reactive({
            name: '',
        })
        return {
            selectedValue: ref(null),
            search
        }
    },
    methods: {
        refresh(e: any) {
            console.log(e.id);
        },
    }
})
</script>

<style lang="scss" scoped>
.n-card--bordered {
    border: 0;
}
</style>