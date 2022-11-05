const storeTable = {
    namespaced: true,
    state() {
        return {
            selectDragArr: [],
            tableDrag: [],
        }
    },
    getters: {
        getTableDrag(state: {
            tableDrag: any;
        }) {
            return state.tableDrag;
        },
        getSelectDragArr(state: {
            selectDragArr: any;
        }) {
            return state.selectDragArr;
        }
    },
    mutations: {
        SET_TABLE_DRAG: (state: { tableDrag: any; }, dragArr: any) => {
            state.tableDrag = dragArr
        },
        SET_SELECT_DRAG_ARR: (state: { selectDragArr: any; }, dragArr: any) => {
            state.selectDragArr = dragArr
        },
    },
    actions: {
        setTableDrag({
            commit
        }: any, dragArr: any) {
            commit('SET_TABLE_DRAG', dragArr)
        },

        setSelectDrag({
            commit
        }: any, dragArr: any) {
            commit('SET_SELECT_DRAG_ARR', dragArr)
        },
    }
}
export default storeTable;