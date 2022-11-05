const menu = {
    namespaced: true,
    state() {
        return {
            activeKey: '',
        }
    },
    getters: {
        getActiveKey(state: { activeKey: any; }) {
            return state.activeKey;
        }
    },
    mutations: {
        SET: (state: { activeKey: any; }, activeKey: any) => {
            state.activeKey = activeKey
        },
    },
    actions: {
        setActiveKey({
            commit
        }: any, activeKey: any) {
            commit('SET', activeKey)
        },

    }
}
export default menu;