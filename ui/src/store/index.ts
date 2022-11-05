import { createStore, Store } from 'vuex'
// import { defineStore } from 'pinia'
import themeStore from './theme'
import userStore from './auth'
import adminMenuStore from './admin/menu'
import adminTableStore from './admin/table'
import adminNavStore from './admin/nav'

export const store = createStore({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        theme: themeStore,
        auth: userStore,
        menuStore: adminMenuStore,
        tableStore:adminTableStore,
        adminNavStore:adminNavStore
    },
})