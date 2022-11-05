import { h, ref, reactive } from "vue";
import RequestHttp from "@/utils/http/http";
import type { DataTableColumns } from 'naive-ui'
import { RowData } from "naive-ui/es/data-table/src/interface";
import { NImage } from "naive-ui";


class TableDataHelper {
    getDataLists: any = async (url: string, param: any) => {
        return await RequestHttp.get(url, param);
    }
    pagination = reactive({
        page: 1,
        pageSize: 20,
        pageCount: 0,
        showSizePicker: true,
        pageSizes: [20, 50, 100],
        onChange: (page: number) => {
            this.pagination.page = page;
        },
        onUpdatePageSize: (pageSize: number) => {
            this.pagination.pageSize = pageSize
            this.pagination.page = 1
        },
    })
    config: any = {
        url: '',
        handle: [],// 配置你的格外按钮数据
    }

    constructor(opt: {}) {
        const config = this.config
        this.config = {
            ...config,
            ...opt
        }
    }

    public async getTableData(search: any = null) {

        const paginationReactive = this.pagination

        const param = {
            page: paginationReactive.page,
            limit: paginationReactive.pageSize,
            ...search
        }

        const { data } = await this.getDataLists(this.config.url, param);
        if (data && data.list) {
            const attribute = data.attribute;
            const tabTitle = data.tabTitle;
            const listCount = Math.ceil(data.list.count / this.pagination.pageSize);
            const sqlUid = data.list.uid;
            this.pagination.pageCount = listCount;

            const columns: RowData[] = [];

            if (this.config.isSelection) {
                columns.push({
                    type: 'selection',
                    fixed: 'left',
                })
            }

            tabTitle.forEach((element: any) => {
                if (element.template == "image") {
                    columns.push({
                        title: element.label,
                        key: element.prop,
                        width: element.width,
                        ellipsis: {
                            tooltip: true
                        },
                        sorter: true,
                        render: (row: any) => {
                            return h(
                                NImage, {
                                width: 30,
                                height: 30,
                                lazy:true,
                                src: row[element.prop],
                            }
                            )
                        }
                    })
                } else {
                    columns.push({
                        title: element.label,
                        key: element.prop,
                        width: element.width,
                        ellipsis: {
                            tooltip: true
                        },
                        sorter: true,
                    })
                }
            });

            if (this.config.handle.length > 0) {
                this.config.handle.forEach((element: DataTableColumns<RowData>) => {
                    columns.push(element);
                });
            }


            return {
                columns,
                attribute,
                tabTitle: data.tabTitle,
                lists: data.list.data,
                loading: false,
                paginationReactive,
                listCount,
                sqlUid,
            }
        }
    }

    // 选择数据
    public selectRowArray(e: any) {
        console.log("selectArray", e)
    }

    // 页数
    public handlePageChange(currentPage: number) {
        console.log('currentPage', currentPage);
    }

    // 筛选
    public handleFiltersChange(filters: any) {
        console.log('filters', filters)
    }
}

export default TableDataHelper;