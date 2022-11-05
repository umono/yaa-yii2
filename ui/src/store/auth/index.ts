import Auth from '@/utils/auth';
import RequestHttp from "@/utils/http/http";

const user = {
    namespaced: true,
    state() {
        return {
            user: null,
            groupAcl: [],
            groupMenus: [],
            groupMenuKey: [],
        }
    },
    getters: {
        getUser(state: { user: any; }) {
            return state.user;
        },
        isRouteInAcl: (state: { groupAcl: string | any[]; }) => (route: any) => {
            return state.groupAcl.includes(route)
        },
        getGroupMenus(state: { groupMenus: any; }) {
            return state.groupMenus;
        },
        getGroupMenuKey(state: { groupMenuKey: any; }) {
            return state.groupMenuKey;
        },
    },
    mutations: {
        INIT_USER: (state: { user: any; }, userInfo: any) => {
            state.user = userInfo;
            window.localStorage.setItem('userInfo', JSON.stringify(userInfo))
        },
        RESET_USER: (state: { user: any; }) => {
            let userInfo = window.localStorage.getItem('userInfo');
            if (userInfo) {
                userInfo = JSON.parse(userInfo);
                state.user = userInfo;
            }
        },
        UPDATE_GROUP_ACL: (state: { groupAcl: any; }, acl: any) => {
            state.groupAcl = acl
        },
        UPDATE_GROUP_MENUS: (state: { groupMenus: any; }, menus: any) => {
            state.groupMenus = menus
        },
        UPDATE_GROUP_MENU_KEY: (state: { groupMenuKey: any; }, menus: any) => {
            state.groupMenuKey = menus
        }
    },
    actions: {
        initClientId({ commit }: any) {
            if (!Auth.getClientId()) {
                Auth.setClientId(Math.random().toString(36).substr(2))
            }
            commit('RESET_USER');
        },
        updateUser({ commit }: any, user: any) {
            commit('INIT_USER', user);
        },
        logout() {
            window.localStorage.clear();
        },
        clear({ commit }: any) {
            window.localStorage.clear();
            commit('INIT_USER', null)
            commit('UPDATE_GROUP_MENUS', [])
            Auth.setAccessToken(null)
            Auth.setClientId(Math.random().toString(36).substr(2))
        },
        login({
            commit
        }: any, user: any) {
            commit('INIT_USER', user);
            Auth.setAccessToken(user.token);
        },
        authentication({ commit }: any) {
            return RequestHttp.get('admin/api/auth/authentication').then((r: any) => {
                commit('UPDATE_GROUP_ACL', r.data.groupAcl);
                commit('UPDATE_GROUP_MENUS', r.data.groupMenus);
                commit('UPDATE_GROUP_MENU_KEY', r.data.groupMenuKey);
                return r;
            })
        }
    }
}
export default user;