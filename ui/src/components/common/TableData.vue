<template>
    <n-card class="table-data-box">
        <div class="table-head-box">
            <div class="button-group">
                <n-button quaternary @click="showPopModal = true">
                    <Icon>
                        <Filter24Filled />
                    </Icon>
                </n-button>
                <slot name="btn"></slot>
            </div>
            <n-space class="slot-head" v-if="useSlot">
                <slot>
                </slot>
                <n-button strong secondary circle @click="goToData">
                    <Icon>
                        <Search24Filled />
                    </Icon>
                </n-button>
            </n-space>

        </div>
        <n-image-group>
            <n-data-table virtual-scroll :max-height="(screenHeight - subHeight)" :bordered="bordered" ref="tableRef"
                :loading="loading" remote :columns="columns" :data="lists" :row-key="rowKey"
                :scroll-x="180 * columns.length" :pagination="pagination" v-model:checked-row-keys="selectArrayRows"
                @update:sorter="handleSorterChange" />
        </n-image-group>
        <TablePop :ref="'tablePop_' + url" v-model:showModal="showPopModal" :attribute="attribute" :toUrl="url"
            :tableTitle="tableTitle" @updateSelect="updateSelect" v-model:selectRowArr="selectArrayRows" />
    </n-card>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, useSlots, watch, h, computed } from 'vue'
import TableDataHelper from "@/composable/TableDataHelper"
import { NButton } from 'naive-ui';
import { Icon } from '@vicons/utils';
import { Filter24Filled, Search24Filled } from '@vicons/fluent';
import TablePop from "./TablePop.vue"
import cryptojs from "@/utils/cryptojs";
import { debounce, isEqual } from '@/plugins/lodash';
// type customButton = {
//     size: string,
//     type: string,
//     emitFunction: string,
//     text: string
// }
export default defineComponent({
    components: { Icon, Filter24Filled, Search24Filled, TablePop },
    props: {
        // search参数改变时会发生请求数据，实现搜索需要传递search参数，在搜索时并改变它
        search: {
            default: {},
            type: Object,
        },
        url: {
            default: '',
            type: String,
        },
        minHeight: {
            default: 200,
            type: Number,
        },
        maxHeight: {
            default: 600,
            type: Number,
        },
        handle: {
            default: [],
            type: Array
        },
        subHeight: {
            default: 0,
            type: Number,
        },
        isSelection: {
            default: true,
            type: Boolean
        },
        bordered: {
            default: true,
            type: Boolean
        },
        scrollX: {
            default: 1800,
            type: Number
        }
    },
    setup(props, ctx) {
        // 处理 btn按钮数据
        const _handle = props.handle;
        _handle.forEach((element: any) => {
            element.render = (row: any) => {
                const buttons = element.NButtons.map((button: any) => {
                    return h(
                        NButton, {
                        style: {
                            marginRight: '6px'
                        },
                        size: button.size || 'small',
                        type: button.type,
                        secondary: true,
                        onClick: () => {
                            ctx.emit(button.emitFunction, row)
                        }
                    }, {
                        default: () => {
                            if (typeof (button.text) == "function") {
                                return button.text(row)
                            } else {
                                return button.text;
                            }
                        }
                    }
                    )
                })
                return buttons;
            }
        });

        const _tableDataHelper = new TableDataHelper({
            url: props.url,
            handle: _handle,
            isSelection: props.isSelection
        });

        let lists = ref([]);
        let attribute = ref([]);
        let tableTitle = ref([]);
        let sqlUid = ref('');
        let columns = ref([]);
        let listCount = ref(0);
        let loadingRef = ref(true);
        let pagination = _tableDataHelper.pagination;
        let search = props.search;
        search.select = [];
        let selectArrayRows = ref<Array<string | number>>([])



        // 初始化时进行 search select查询数据
        const name = cryptojs.Encrypt(props.url);
        let _dragData: any = window.localStorage.getItem(name);
        if (_dragData) {
            _dragData = JSON.parse(_dragData);
            if (_dragData && _dragData.dragArr.length > 0) {
                const _selectArr: any[] = [];
                _dragData.dragArr.forEach((_dragArr: { prop: any; }) => {
                    _selectArr.push(_dragArr.prop);
                })

                search.select = _selectArr;
            }
        }
        // 请求页面的数据
        const goToData = async () => {
            loadingRef.value = true;
            const res: any = await _tableDataHelper.getTableData(search);
            if (res) {
                lists.value = res.lists;
                columns.value = res.columns;
                listCount.value = res.listCount;
                attribute.value = res.attribute;
                tableTitle.value = res.tabTitle;
                sqlUid.value = res.sqlUid;
                selectArrayRows.value = [];
            }
            loadingRef.value = false;
        }

        onMounted(()=>{
            goToData();
        });

        // 监听页面页码、数量
        watch([
            () => pagination.page,
            () => pagination.pageSize,
        ], goToData, { deep: true });

        const lazySearch = debounce(() => {
            goToData();
        }, 1000)
        // watch(() => search, (n) => {
        //     console.log("search ??",n)
        //     lazySearch()

        // }, { deep: true, immediate: true })

        let screenHeight = ref(window.innerHeight - 75);

        // window.onresize = () => {
        //     return (() => {
        //         screenHeight.value = window.innerHeight - 75;
        //     })()
        // }

        return {
            search,
            loading: loadingRef,
            rowKey: (row: any) => row.id,
            pagination,
            lists,
            columns,
            listCount,
            goToData,
            // handlePageChange: _tableDataHelper.handlePageChange,
            // handleFiltersChange: _tableDataHelper.handleFiltersChange,
            screenHeight,
            useSlot: !!useSlots().default,
            showPopModal: ref(false),
            attribute,
            tableTitle,
            sqlUid,
            selectArrayRows,
        }
    },
    methods: {
        handleSorterChange(e: any) {
            this.search._order_by = e.columnKey + '-' + (e.order == 'descend' ? 'desc' : 'ascending');
        },
        updateSelect(val: any) {
            const _select = this.search.select;
            const _arr: any[] = [];
            val.forEach((arr: { prop: any; }) => {
                _arr.push(arr.prop);
            });
            if (!isEqual(_arr, _select)) {
                this.search.select = _arr;
            }
        }
    }
})
</script>
<style lang="scss" scoped>
.table-data-box {
    width: 100%;
    transition: all 0.01s !important;
    border: 0;

    .table-head-box {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 10px;

        .button-group {
            padding: 6px;
            background-color: var(--n-border-color);
            border-radius: 32px;
            display: flex;
            align-items: center;
            margin-right: 10px;

            :deep(.n-button__content) {
                font-weight: 700 !important;
            }

            :deep(.n-button) {
                border-radius: 16px;
            }

            :deep(.n-button:hover) {
                background-color: $primaryColor;
                color: lighten($primaryColor, 90%);
            }

            :deep(.n-button:focus) {
                background-color: $primaryColor;
                color: lighten($primaryColor, 90%);
            }
        }

        .slot-head {
            display: flex;
            align-items: center;
        }
    }
}
</style>