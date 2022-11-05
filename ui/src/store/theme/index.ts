import { darkTheme, zhCN, dateZhCN } from 'naive-ui'
const theme = {
    namespaced: true,
    state() {
        return {
            theme: null,
            locale: zhCN,
            dateLocale: dateZhCN,
            haveForward: false,
        }
    },
    getters: {
        getTheme(state: { theme: any; }) {
            return state.theme;
        },
        getHaveForward(state: any) {
            return state.haveForward;
        },
    },
    mutations: {
        INIT_THEME: (state: any) => {
            const darkMode = window.localStorage.getItem("darkMode")
            if (darkMode == undefined) {
                if (state.theme) {
                    window.localStorage.setItem("darkMode", "true")
                } else {
                    window.localStorage.setItem("darkMode", "false")
                }
            } else {
                if (darkMode == "true") {
                    state.theme = darkTheme;
                } else {
                    state.theme = null;
                }
            }
        },
        TOGGLE_THEME: (state: { theme: any; }, selectTheme: any) => {
            if (selectTheme) {
                state.theme = darkTheme;
                window.localStorage.setItem("darkMode", "true")
            } else {
                state.theme = null;
                window.localStorage.setItem("darkMode", "false")
            }
        },

        TOGGLE_LANGUAGE: (state: { locale: any; dateLocale: any }, language: string) => {
            if (language == "zh-CN") {
                state.locale = zhCN
                state.dateLocale = dateZhCN
            } else {
                state.locale = null
                state.dateLocale = null
            }
        },
        TOGGLE_ROUTER_STATUS: (state: { haveForward: Boolean }, haveForward: Boolean) => {
            state.haveForward = haveForward
        },
    },
    actions: {
        init({ commit }: any) { commit("INIT_THEME"); },
        toggle({ commit }: any, theme: any) { commit('TOGGLE_THEME', theme) },
        toggleLanguage({ commit }: any, language: any) { commit('TOGGLE_LANGUAGE', language) },
        toggleRouter({ commit }: any, haveForward: Boolean) { commit('TOGGLE_ROUTER_STATUS', haveForward) },
    }
}
export default theme;