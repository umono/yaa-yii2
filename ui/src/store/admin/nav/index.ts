

import router from '@/router';
const navTabKey = "yaa-tabs-nav";
const store = {
    namespaced: true,
    state() {
        return {
            tabs: [
                {
                    path: '/admin/home',
                    title: '控制台',
                    pin: false,
                }
            ],
            currentTab: [],
            showTabs: false,
        }
    },
    getters: {
        getTabs(state: {
            tabs: any;
        }) {
            return state.tabs;
        },
        getCurrentTab(state: {
            currentTab: any;
        }) {
            return state.currentTab;
        },
        getShowTabs(state: {
            showTabs: boolean;
        }) {
            return state.showTabs;
        }
    },
    mutations: {
        INIT_TABS: (state: { tabs: any; showTabs: boolean }, arr: any) => {
            const tabs = window.localStorage.getItem(navTabKey);
            const ifShowTabs = window.localStorage.getItem("if" + navTabKey);

            if (tabs && tabs.length > 0) {
                state.tabs = JSON.parse(tabs)
            }

            if (ifShowTabs) {
                state.showTabs = JSON.parse(ifShowTabs);
            }
        },
        ADD_TABS: (state: {
            currentTab: any; tabs: any;
        }, arr: any) => {
            if (state.tabs.length > 0) {
                let have = false;
                for (let index = 0; index < state.tabs.length; index++) {
                    if (arr.title == state.tabs[index].title) {
                        have = true;
                    }
                }
                if (!have) {
                    state.tabs.push(arr);
                }
            } else {
                state.tabs.push(arr);
            }
            state.currentTab = arr;

            window.localStorage.setItem(navTabKey, JSON.stringify(state.tabs));
        },
        DELETE_TABS: (state: { tabs: any; currentTab: any }, currentTabTitle: any) => {
            let newRoute: any = null;

            let cuIndex: any = null;
            let delIndex: any = null;
            let sumLength = state.tabs.length;
            // 获取删除的index，以及当前的index，当删除的tab是当前页面的tab时，往前进或者往后进
            state.tabs.forEach((element: { title: any; }, index: any) => {
                if (element.title == currentTabTitle) {
                    delIndex = index;
                }
                if (element.title == state.currentTab.title) {
                    cuIndex = index;
                }
            });


            state.tabs.splice(delIndex, 1);

            if (delIndex == cuIndex) {
                if (cuIndex + 1 >= sumLength) {
                    newRoute = state.tabs[cuIndex - 1];
                } else {
                    newRoute = state.tabs[cuIndex];
                }
            }

            window.localStorage.setItem(navTabKey, JSON.stringify(state.tabs));
            // new router
            if (newRoute) {
                state.currentTab = newRoute;
                router.push(newRoute.path)
            }
        },
        SET_SHOW_TABS(state: { showTabs: any }) {
            state.showTabs = !state.showTabs;
            window.localStorage.setItem("if" + navTabKey, state.showTabs);
        }
    },
    actions: {
        initTabs({
            commit
        }: any, tab: any) {
            commit('INIT_TABS', tab)
        },
        addTab({
            commit
        }: any, tab: any) {
            commit('ADD_TABS', tab)
        },
        deleteTab({
            commit
        }: any, tab: any) {
            commit('DELETE_TABS', tab)
        },
        setShowTabs({
            commit
        }: any, tab: any) {
            commit('SET_SHOW_TABS', tab)
        }
    }
}
export default store;