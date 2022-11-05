<template>
    <n-drawer v-model:show="showModal" placement="left" width="268">
        <n-drawer-content title="筛选">
            <div class="custom-card">
                <n-collapse arrow-placement="right">
                    <n-collapse-item title="自选择列" name="1">
                        <n-checkbox-group v-model:value="selectColumnArr">
                            <n-space item-style="display: flex;">
                                <n-checkbox v-for="item in attribute" :key="item.prop" :label="item.label"
                                    :value="item.prop">
                                </n-checkbox>
                            </n-space>
                        </n-checkbox-group>
                    </n-collapse-item>
                    <n-collapse-item title="显示顺序" name="2">
                        <n-space>
                            <draggable class="wrapper" v-model="dragData.dragArr" v-bind="dragOptions"
                                @start="dragData.drag = true" @end="dragData.drag = false;" item-key="prop">
                                <template #item="{ element }">
                                    <n-button tertiary class="drag-bt">
                                        {{ element.label }}
                                    </n-button>
                                </template>
                            </draggable>
                        </n-space>
                    </n-collapse-item>
                    <n-collapse-item title="其他操作" name="3">
                        <n-space class="action-btn">
                            <n-button tertiary @click="exportSelectRow">
                                导出所选
                            </n-button>
                            <n-button tertiary type="primary" @click="exportAll">
                                导出所有
                            </n-button>
                            <n-button tertiary type="error" @click="deleteMsgModel.show = !deleteMsgModel.show">
                                删除所选
                            </n-button>
                            <div v-if="deleteMsgModel.show" class="mt-2">
                                <n-input v-model:value="deleteMsgModel.msg" type="textarea" placeholder="请输入删除原因" />
                                <n-button class="mt-2" @click="deleteSelectRows" strong secondary>
                                    确定删除
                                </n-button>
                            </div>

                        </n-space>
                    </n-collapse-item>
                </n-collapse>
            </div>
            <template #footer>
                <slot name="footer">
                    <n-space>
                        <n-button @click="close" strong secondary>取消</n-button>
                        <n-button type="primary" @click="onSubmit" :loading="loading" strong secondary>确定</n-button>
                    </n-space>
                </slot>
            </template>
        </n-drawer-content>
    </n-drawer>
</template>

<script lang="ts">
import { defineComponent, ref, watch, reactive, PropType, Ref, computed, onUnmounted } from 'vue';
import Draggable from 'vuedraggable';
import cryptojs from "@/utils/cryptojs";
import { useStore } from 'vuex';
import { difference } from '@/plugins/lodash';

interface columnType {
    prop: string,
    label: string,
    sort: string,
    width: number
}

export default defineComponent({
    components: { Draggable },
    props: {
        toModel: {
            default: null,
            type: Object,
        },
        toUrl: {
            default: '',
            type: String,
        },
        showModal: {
            default: false,
            type: Boolean
        },
        tableTitle: {
            default: [],
            type: Array as PropType<columnType[]>,
        },
        attribute: {
            type: Array as PropType<columnType[]>,
            default: []
        },
        selectRowArr: {
            type: Array,
            default: []
        }
    },

    setup(props, ctx) {
        const reload: any = inject("reload")
        const store = useStore();

        let toUrl: any = ref('');
        let toModel: any = ref({});
        let showModal: any = ref(false);
        let selectColumnArr = ref(store.getters['tableStore/getSelectDragArr']);
        let selectRowArray = ref([])

        toUrl.value = props.toUrl;
        toModel.value = props.toModel;
        showModal.value = props.showModal;


        watch(() => props.showModal, (val: boolean) => {
            showModal.value = val;
        });

        watch(() => props.selectRowArr, (arr: any) => {
            selectRowArray.value = arr;
        });



        const name = cryptojs.Encrypt(props.toUrl);

        const dragOptions = reactive({
            animation: 200,
            group: "description",
            disabled: false,
            ghostClass: "ghost"
        });

        // 拖拽的数据
        let dragData: any = reactive({
            drag: false,
            dragArr: []
        });


        // 将tableTitle 默认勾选上
        watch(() => (props.tableTitle), (t, o) => {
            const _arr: any[] = [];
            t.forEach((_t: any) => {
                _arr.push(_t.prop);
            })
            selectColumnArr.value = _arr;
        }
        );
        //打开时是否有本地缓存在pop选中数据
        watch(showModal, (val: Boolean) => {
            if (val) {
                let _dragData: any = window.localStorage.getItem(name);
                if (_dragData) {
                    _dragData = JSON.parse(_dragData);
                    if (_dragData && _dragData.dragArr.length > 0) {
                        const _selectArr: any[] = [];
                        _dragData.dragArr.forEach((_dragArr: { prop: any; }) => {
                            _selectArr.push(_dragArr.prop);
                        })
                        selectColumnArr.value = _selectArr;
                        dragData.dragArr = _dragData.dragArr;
                    }
                }
            }
            ctx.emit("update:showModal", val)
        });

        // 当勾选上列时，同步到托选中
        watch(() => selectColumnArr.value, (s: any, o: any) => {
            const add = difference(s, o);
            const sub = difference(o, s);
            props.attribute.forEach((a: any) => {
                add.forEach((_add: any) => {
                    if (a.prop == _add) {
                        dragData.dragArr.push(a);
                    }
                })
            })
            sub.forEach((_sub: any) => {
                dragData.dragArr.forEach((_dragA: any, index: any) => {
                    if (_sub == _dragA.prop) {
                        dragData.dragArr.splice(index, 1);
                    }
                })
            })
        });
        return {
            name,
            toUrl,
            toModel,
            showModal,
            loading: ref(false),
            dragOptions,
            dragData,
            selectColumnArr,
            selectRowArray,
            deleteMsgModel: ref({} as any),
            reload
        }
    },
    methods: {
        async onSubmit() {
            // 存储当前拖拽的数据以及选中的数据
            const param = {
                dragArr: this.dragData.dragArr
            };
            const _dragA = JSON.stringify(param);
            window.localStorage.setItem(this.name, _dragA);

            this.$emit("updateSelect", this.dragData.dragArr);

            this.showModal = false;
        },
        close() {
            if (this.loading) {
                return false;
            }
            this.showModal = false;
        },
        async exportSelectRow() {
            if (!this.plzSelectRow()) {
                return;
            }
            this.loading = true;
            const _parent: any = this.$parent?.$parent;
            const currentRouter = this.$store.getters['adminNavStore/getCurrentTab'];
            const param = {
                tableHeader: this.dragData.dragArr,
                search: _parent.search,
                selectRows: this.selectRowArray,
                uid: _parent.sqlUid,
                fileName: currentRouter.title
            }
            await this.$http.download('POST', 'admin/api/export/select', null, param);
            this.showModal = false;
        },
        async exportAll() {
            this.loading = true;
            const _parent: any = this.$parent?.$parent;
            const currentRouter = this.$store.getters['adminNavStore/getCurrentTab'];
            const param = {
                tableHeader: this.dragData.dragArr,
                search: _parent.search,
                selectRows: this.selectRowArray,
                uid: _parent.sqlUid,
                fileName: currentRouter.title
            }
            await this.$http.download('POST', 'admin/api/export/all', null, param);
            this.showModal = false;
        },
        async deleteSelectRows() {
            if (!this.deleteMsgModel.show) return;
            if (!this.plzSelectRow()) return;

            this.loading = true;
            const _parent: any = this.$parent?.$parent;
            const param = {
                list: this.selectRowArray,
                uid: _parent.sqlUid,
                deleteMsgModel: this.deleteMsgModel,
            }
            this.loading = false;
            const { msg } = await this.$http.post('admin/api/delete/select', param);
            window.$message.success(msg);
            this.showModal = false;
            this.reload();

        },
        plzSelectRow() {
            if (this.selectRowArray.length <= 0) {
                window.$message.warning("请选择数据后重试")
                return false;
            } else {
                return true;
            }
        }
    }
})
</script>

<style lang="scss" scoped>
.custom-card {
    :deep(.n-collapse-item__header-main) {
        justify-content: space-between !important;
    }

    .drag-bt {
        margin-left: 10px;
        margin-bottom: 10px;
    }

    :deep(.n-collapse-item__header-main) {
        font-weight: 700 !important;
    }

    .n-button {
        font-weight: 700 !important;
    }
}
</style>